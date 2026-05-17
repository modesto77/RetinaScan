<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('scans', function (Blueprint $table) {
        $table->id();
        
        // LIEN AVEC LE PATIENT
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        
        // QUEL ŒIL ? (OD = Oculus Dexter/Droit, OG = Oculus Sinister/Gauche)
        $table->enum('eye_side', ['OD', 'OG']);
        
        // IMAGE
        $table->string('image_path'); // Chemin vers storage/app/public/...
        
        // PARTIE 1 : L'IA (Automatique)
        $table->string('ai_result')->nullable();     // Ex: "Stade 3 : Sévère"
        $table->float('ai_confidence')->nullable();  // Ex: 98.50
        
        // PARTIE 2 : LE MÉDECIN (Validation)
        $table->string('final_diagnosis')->nullable(); // Le diagnostic réel validé
        $table->text('prescription')->nullable();      // Le traitement donné
        $table->text('doctor_notes')->nullable();      // Notes privées
        
        // STATUT DU WORKFLOW
        // 'brouillon' = L'IA a fini, le médecin doit vérifier.
        // 'valide' = Le médecin a confirmé, c'est enregistré dans le dossier.
        $table->string('status')->default('brouillon');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};
