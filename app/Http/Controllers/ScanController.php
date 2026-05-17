<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ScanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        //
        return view('scans.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'eye_side' => 'required|in:OD,OG',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Max 10MB
        ]);

        // 1. Sauvegarder l'image dans le dossier "storage/app/public/scans"
        $cleanName = Str::slug($patient->last_name . '-' . $patient->first_name);

        //On recupere le type de Diabete
        $typeDiabete = Str::slug($patient->diabetes_type ?? 'inconnu');

        // On ajoute l'œil (OD/OG)
        $eye = $request->eye_side;

        // On ajoute le timestamp (l'heure exacte) pour éviter les doublons si on scanne 2 fois
        $timestamp = time();

        // On récupère l'extension originale (.jpg, .png)
        $extension = $request->file('image')->getClientOriginalExtension();

        // Résultat : "dupont-jean_OD_Type2_170245899.jpg"
        $fileName = "{$cleanName}_{$eye}_{$typeDiabete}_{$timestamp}.{$extension}";

        // 2. ENREGISTREMENT AVEC 'storeAs'
        // Au lieu de 'store' (qui génère un nom aléatoire), on utilise 'storeAs'
        $path = $request->file('image')->storeAs('scans', $fileName, 'public');

        $aiResult = null;
        $aiConfidence = null;

        try {
            // On récupère le contenu brut du fichier pour l'envoyer
            $fileContent = file_get_contents(storage_path('app/public/' . $path));

            // On envoie une requête POST à notre script Python (port 5001)
            $response = Http::attach(
                'file',
                $fileContent,
                $fileName
            )->post('http://127.0.0.1:5001/predict');

            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    $aiResult = $data['result'];       // Ex: "Stade 2 : Modérée"
                    $aiConfidence = $data['confidence']; // Ex: 98.5
                }
            }
        } catch (\Exception $e) {
            // Si le serveur Python est éteint, on ne fait pas planter Laravel,
            // on enregistre juste sans résultat IA.
            // Tu pourras ajouter un log ici : Log::error($e->getMessage());
        }

        // 4. Création en Base de Données (avec les résultats IA !)
        $scan = Scan::create([
            'patient_id' => $patient->id,
            'eye_side' => $request->eye_side,
            'image_path' => $path,
            'ai_result' => $aiResult,          // Rempli automatiquement
            'ai_confidence' => $aiConfidence,  // Rempli automatiquement
            'status' => $aiResult ? 'brouillon' : 'erreur_ia', // Petit bonus statut
        ]);

        $message = $aiResult
            ? 'Analyse IA terminée : ' . $aiResult
            : 'Image enregistrée, mais le serveur IA ne répondait pas.';

        return redirect()->route('scans.show', $scan->id) // On redirige direct vers le résultat
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Scan $scan)
    {
        //
        if ($scan->patient->user_id !== Auth::id()) abort(403);

        return view('scans.show', compact('scan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scan $scan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scan $scan)
    {
        //
        if ($scan->patient->user_id !== Auth::id()) abort(403);

        $request->validate([
            'final_diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'doctor_notes' => 'nullable|string',
        ]);

        $scan->update([
            'final_diagnosis' => $request->final_diagnosis,
            'prescription' => $request->prescription,
            'doctor_notes' => $request->doctor_notes,
            'status' => 'valide' // Le dossier passe de "brouillon" à "valide"
        ]);

        return redirect()->route('scans.show', $scan->id)
            ->with('success', 'Diagnostic validé et enregistré.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scan $scan)
    {
        //
        // 1. SÉCURITÉ : Vérifier que ce scan appartient bien à un patient du médecin connecté
        if ($scan->patient->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        // 2. SUPPRESSION DU FICHIER IMAGE
        // On vérifie si le fichier existe sur le disque 'public' avant de le supprimer
        if ($scan->image_path && Storage::disk('public')->exists($scan->image_path)) {
            Storage::disk('public')->delete($scan->image_path);
        }

        // 3. SUPPRESSION EN BASE DE DONNÉES
        $scan->delete();

        // 4. RETOUR AU DOSSIER PATIENT
        return redirect()->route('patients.show', $scan->patient_id)
            ->with('success', 'Scan et image supprimés définitivement.');
    }

    // RELANCER L'ANALYSE IA MANUELLEMENT
    public function analyze(Scan $scan)
    {
        // 1. Sécurité
        if ($scan->patient->user_id !== Auth::id()) abort(403);

        // 2. Vérifier que le fichier existe toujours
        if (!Storage::disk('public')->exists($scan->image_path)) {
            return back()->with('error', 'Le fichier image est introuvable sur le serveur.');
        }

        // 3. Préparer l'appel à Python
        $aiResult = null;
        $aiConfidence = null;
        $message = "Erreur : Le serveur IA ne répond pas.";

        try {
            // On récupère le fichier existant
            $fullPath = storage_path('app/public/' . $scan->image_path);
            $fileContent = file_get_contents($fullPath);

            // On retrouve le nom du fichier (juste pour l'envoi)
            $fileName = basename($scan->image_path);

            // Appel API
            $response = Http::attach(
                'file',
                $fileContent,
                $fileName
            )->post('http://127.0.0.1:5001/predict');

            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    $aiResult = $data['result'];
                    $aiConfidence = $data['confidence'];
                    $message = "Nouvelle analyse réussie : " . $aiResult;
                }
            }
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            $message = "Erreur technique : Vérifiez que le script Python est lancé.";
        }

        // 4. Mise à jour seulement si on a un résultat
        if ($aiResult) {
            $scan->update([
                'ai_result' => $aiResult,
                'ai_confidence' => $aiConfidence,
                'status' => 'brouillon' // On repasse en brouillon pour validation
            ]);
            return back()->with('success', $message);
        } else {
            // Si échec, on met le statut erreur
            $scan->update(['status' => 'erreur_ia']);
            return back()->with('error', $message);
        }
    }
    // CHANGER L'IMAGE D'UN SCAN EXISTANT
    public function updateImage(Request $request, Scan $scan)
    {
        // 1. Sécurité
        if ($scan->patient->user_id !== Auth::id()) abort(403);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // 2. Supprimer l'ancienne image physique
        if (Storage::disk('public')->exists($scan->image_path)) {
            Storage::disk('public')->delete($scan->image_path);
        }

        // 3. Préparer le nouveau nom (Même logique que le store)
        $cleanName = Str::slug($scan->patient->last_name . '-' . $scan->patient->first_name);
        $typeDiabete = Str::slug($scan->patient->diabetes_type ?? 'inconnu');
        $eye = $scan->eye_side; // On garde le même œil
        $timestamp = time();
        $extension = $request->file('image')->getClientOriginalExtension();

        $fileName = "{$cleanName}_{$eye}_{$typeDiabete}_{$timestamp}.{$extension}";

        // 4. Enregistrer la nouvelle image
        $path = $request->file('image')->storeAs('scans', $fileName, 'public');

        // 5. Mettre à jour la BDD et RESET L'IA
        $scan->update([
            'image_path' => $path,
            'ai_result' => null,       // On efface l'ancien résultat
            'ai_confidence' => null,   // On efface l'ancienne confiance
            'status' => 'brouillon'    // On remet le statut à zéro
        ]);

        return back()->with('success', 'Image remplacée. Veuillez relancer l\'analyse IA.');
    }

    //Generation du rapport, format PDF
    public function downloadPdf(Request $request, Scan $scan)
    {
        // 1. Sécurité
        if ($scan->patient->user_id !== Auth::id()) abort(403);

        // 2. Validation et Récupération
        $request->validate(['signature' => 'required']);

        $format = $request->input('format', 'pdf');
        $signatureData = $request->input('signature');

        // 3. Génération du nom de fichier propre
        $cleanName = Str::slug($scan->patient->last_name . '-' . $scan->patient->first_name);
        $typeDiabete = Str::slug($scan->patient->diabetes_type ?? 'inconnu');
        $eye = $scan->eye_side;
        $timestamp = time();

        // Nom de base sans extension
        $baseFileName = "Rapport_{$cleanName}_{$eye}_{$typeDiabete}_{$timestamp}";

        // ==========================================
        // OPTION A : GÉNÉRATION IMAGE (JPG)
        // ==========================================
        if ($format === 'image') {

            // 1. Toile Blanche (Format A4 approx)
            $width = 800;
            $height = 1100; // Hauteur légèrement réduite pour plus de compacité
            $img = imagecreatetruecolor($width, $height);

            // 2. Définition des couleurs
            $white = imagecolorallocate($img, 255, 255, 255);
            $black = imagecolorallocate($img, 30, 30, 30);
            $grayText = imagecolorallocate($img, 100, 100, 100);
            $blue = imagecolorallocate($img, 37, 99, 235); // Bleu RetinaScan
            $lightGray = imagecolorallocate($img, 243, 244, 246);
            $borderGray = imagecolorallocate($img, 220, 220, 220);

            // Remplir le fond en blanc
            imagefilledrectangle($img, 0, 0, $width, $height, $white);

            // 3. CONFIGURATION POLICE (Votre chemin spécifique)
            $fontPath = public_path('fonts/OpenSans-VariableFont_wdth_wght.ttf');
            $hasFont = file_exists($fontPath);

            // --- Fonction Helper pour écrire du texte avec accents ---
            $text = function ($size, $x, $y, $content, $color) use ($img, $fontPath, $hasFont) {
                if ($hasFont) {
                    imagettftext($img, $size, 0, $x, $y, $color, $fontPath, $content);
                } else {
                    $gdSize = max(1, min(5, round($size / 3)));
                    imagestring($img, $gdSize, $x, $y - 15, utf8_decode($content), $color);
                }
            };

            // --- Fonction Helper pour centrer du texte ---
            $center = function ($size, $y, $content, $color, $maxWidth) use ($img, $fontPath, $hasFont, $text) {
                if ($hasFont) {
                    $box = imagettfbbox($size, 0, $fontPath, $content);
                    $textW = abs($box[4] - $box[0]);
                    $x = ($maxWidth - $textW) / 2;
                    $text($size, $x, $y, $content, $color);
                } else {
                    $fontW = imagefontwidth(4);
                    $x = ($maxWidth - (strlen($content) * $fontW)) / 2;
                    imagestring($img, 4, $x, $y - 15, utf8_decode($content), $color);
                }
            };

            // --- DÉBUT DU DESSIN DU RAPPORT (Compact) ---
            $y = 50;

            // LOGO & TITRE
            $logoPath = public_path('logo.png');
            if (file_exists($logoPath)) {
                $logoSrc = imagecreatefrompng($logoPath);
                $logoW = imagesx($logoSrc);
                $logoH = imagesy($logoSrc);
                $newLogoH = 35;
                $newLogoW = ($logoW / $logoH) * $newLogoH;

                imagecopyresampled($img, $logoSrc, 40, $y - 30, 0, 0, $newLogoW, $newLogoH, $logoW, $logoH);
                $text(20, 40 + $newLogoW + 12, $y, "RetinaScan", $blue);
            } else {
                $text(20, 40, $y, "RetinaScan", $blue);
            }
            $text(9, 40, $y + 20, "Cabinet d'Ophtalmologie", $grayText);

            // INFO DOCTEUR (Droite)
            $docName = "Dr. " . Auth::user()->name;
            $dateText = "Le " . now()->format('d/m/Y');

            if ($hasFont) {
                $box = imagettfbbox(11, 0, $fontPath, $docName);
                $w = abs($box[4] - $box[0]);
                $text(11, $width - 40 - $w, $y, $docName, $black);

                $boxD = imagettfbbox(9, 0, $fontPath, $dateText);
                $wD = abs($boxD[4] - $boxD[0]);
                $text(9, $width - 40 - $wD, $y + 18, $dateText, $grayText);
            } else {
                imagestring($img, 4, $width - 200, $y - 10, utf8_decode($docName), $black);
                imagestring($img, 2, $width - 200, $y + 10, $dateText, $grayText);
            }

            // Ligne de séparation fine
            $y += 40;
            imagefilledrectangle($img, 40, $y, $width - 40, $y + 1, $blue);
            $y += 25;

            // SECTION PATIENT (Compacte)
            imagefilledrectangle($img, 40, $y, $width - 40, $y + 28, $lightGray);
            imagefilledrectangle($img, 40, $y, 44, $y + 28, $blue);
            $text(10, 55, $y + 20, "PATIENT", $black);
            $y += 50;

            $text(10, 40, $y, "Nom :", $black);
            $text(11, 130, $y, strtoupper($scan->patient->last_name) . " " . $scan->patient->first_name, $black);

            $text(10, 420, $y, "Dossier :", $black);
            $text(11, 510, $y, "#" . $scan->patient->id, $black);
            $y += 28;

            $text(10, 40, $y, "Né(e) le :", $black);
            $text(11, 130, $y, \Carbon\Carbon::parse($scan->patient->date_of_birth)->format('d/m/Y'), $black);

            $text(10, 420, $y, "Diabète :", $black);
            $text(11, 510, $y, $scan->patient->diabetes_type ?? 'Non spécifié', $black);
            $y += 45;

            // SECTION IMAGERIE
            imagefilledrectangle($img, 40, $y, $width - 40, $y + 28, $lightGray);
            imagefilledrectangle($img, 40, $y, 44, $y + 28, $blue);
            $text(10, 55, $y + 20, "IMAGERIE RÉTINIENNE", $black);
            $y += 40;

            $scanPath = public_path('storage/' . $scan->image_path);
            if (file_exists($scanPath)) {
                $info = getimagesize($scanPath);
                $source = null;
                if ($info['mime'] == 'image/jpeg') $source = imagecreatefromjpeg($scanPath);
                elseif ($info['mime'] == 'image/png') $source = imagecreatefrompng($scanPath);

                if ($source) {
                    $sw = imagesx($source);
                    $sh = imagesy($source);

                    $maxW = $width - 100;
                    $maxH = 300;
                    $ratio = $sw / $sh;

                    $targetH = $maxH;
                    $targetW = $targetH * $ratio;
                    if ($targetW > $maxW) {
                        $targetW = $maxW;
                        $targetH = $targetW / $ratio;
                    }

                    $posX = ($width - $targetW) / 2;
                    imagefilledrectangle($img, $posX - 1, $y - 1, $posX + $targetW + 1, $y + $targetH + 1, $borderGray);
                    imagecopyresampled($img, $source, $posX, $y, 0, 0, $targetW, $targetH, $sw, $sh);
                    $y += $targetH + 15;

                    $legend = ($scan->eye_side == 'OD' ? 'Œil Droit (OD)' : 'Œil Gauche (OG)') . " | " . $scan->created_at->format('d/m/Y H:i');
                    $center(9, $y, $legend, $grayText, $width);
                    $y += 35;
                    imagedestroy($source);
                }
            }

            // --- DIAGNOSTIC ---
            imagefilledrectangle($img, 40, $y, $width - 40, $y + 28, $lightGray);
            imagefilledrectangle($img, 40, $y, 44, $y + 28, $blue);
            $text(10, 55, $y + 20, "DIAGNOSTIC & CONCLUSION", $black);
            $y += 40;

            imagerectangle($img, 40, $y - 10, $width - 40, $y + 55, $black);
            $text(11, 55, $y + 15, "Diagnostic :", $black);
            $text(12, 160, $y + 15, $scan->final_diagnosis ?? 'Non défini', $black);

            $iaText = "(IA : " . ($scan->ai_result ?? 'N/A') . " - " . ($scan->ai_confidence ?? 0) . "%)";
            $text(8, 55, $y + 38, $iaText, $grayText);
            $y += 75;

            // --- PRESCRIPTION ---

            imagefilledrectangle($img, 40, $y, $width - 40, $y + 28, $lightGray);
            imagefilledrectangle($img, 40, $y, 44, $y + 28, $blue);
            $text(10, 55, $y + 20, "PRESCRIPTION", $black);
            $y += 40;
            if ($scan->prescription) {
                $wrappedText = wordwrap($scan->prescription, 85, "\n", true);
                foreach (explode("\n", $wrappedText) as $line) {
                    $text(10, 45, $y, $line, $black);
                    $y += 20;
                }
                $y += 25;
            }

            // --- SIGNATURE (Plus discrète) ---
            if ($signatureData) {
                $sigData = explode(',', $signatureData);
                if (count($sigData) > 1) {
                    $sigContent = base64_decode($sigData[1]);
                    $sigSource = imagecreatefromstring($sigContent);
                    if ($sigSource) {
                        $sw = imagesx($sigSource);
                        $sh = imagesy($sigSource);
                        $newSW = 140;
                        $newSH = ($sh / $sw) * $newSW;
                        $sigX = $width - 200;

                        imagecopyresampled($img, $sigSource, $sigX, $y, 0, 0, $newSW, $newSH, $sw, $sh);
                        imageline($img, $sigX, $y + $newSH + 5, $width - 60, $y + $newSH + 5, $black);
                        $text(9, $sigX + 10, $y + $newSH + 18, "Dr. " . Auth::user()->name, $black);
                        imagedestroy($sigSource);
                    }
                }
            }

            // --- FOOTER ---
            $footerText = "Document généré par RetinaScan - Validé électroniquement.";
            imageline($img, 40, $height - 40, $width - 40, $height - 40, $borderGray);
            $center(8, $height - 20, $footerText, $grayText, $width);

            // Téléchargement
            return response()->streamDownload(function () use ($img) {
                imagejpeg($img, null, 90);
                imagedestroy($img);
            }, $baseFileName . '.jpg');
        }

        // ==========================================
        // OPTION B : GÉNÉRATION PDF (Défaut)
        // ==========================================

        $data = [
            'scan' => $scan,
            'patient' => $scan->patient,
            'doctor' => Auth::user(),
            'date' => now()->format('d/m/Y'),
            'imagePath' => public_path('storage/' . $scan->image_path),
            'signatureData' => $signatureData,
        ];

        $pdf = Pdf::loadView('scans.pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($baseFileName . '.pdf');
    }
}
