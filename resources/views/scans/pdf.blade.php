<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rapport - {{ $patient->last_name }}</title>
    <style>
        /* Marges réduites pour gagner de la place */
        @page {
            margin: 1cm;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #111;
            line-height: 1.3;
        }

        /* En-tête compact */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
        }

        /* Titres de section */
        .section-title {
            background-color: #f3f4f6;
            padding: 5px 8px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            border-left: 4px solid #2563eb;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        /* Tables d'info */
        .info-table td {
            padding: 3px 0;
        }

        .bold {
            font-weight: bold;
        }

        /* Gestion de l'image rétinienne - Taille Fixe Importante */
        .image-container {
            text-align: center;
            margin: 10px 0;
            border: 1px solid #eee;
            padding: 5px;
        }

        .scan-img {
            height: 200px;
            object-fit: contain;
        }

        /* Hauteur forcée pour éviter le débordement */

        /* Diagnostic */
        .diagnosis-box {
            border: 1px solid #333;
            padding: 10px;
            background: #fff;
        }

        /* Signature */
        .signature-section {
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }

        .signature-img {
            height: 60px;
            object-fit: contain;
            margin-bottom: -10px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 5px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 9px;
            text-align: center;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td valign="top">
                <table cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
                    <tr>
                        <td style="vertical-align: middle; padding-right: 10px;">
                            <img src="{{ public_path('logo.png') }}" height="30" style="display: block;">
                        </td>
                        <td style="vertical-align: middle;">
                            <span style="font-size: 20px; font-weight: bold; color: #111; line-height: 1;">
                                Retina<span style="color: #2563eb;">Scan</span>
                            </span>
                        </td>
                    </tr>
                </table>
                <div style="font-size: 12px; color: #555;">Cabinet d'Ophtalmologie</div>
            </td>

            <td valign="top" style="text-align: right;">
                <strong>Dr. {{ $doctor->name }}</strong><br>
                {{ $date }}
            </td>
        </tr>
    </table>

    <div class="section-title">Patient</div>
    <table width="100%" class="info-table">
        <tr>
            <td width="15%" class="bold">Nom :</td>
            <td width="35%">{{ strtoupper($patient->last_name) }} {{ $patient->first_name }}</td>
            <td width="15%" class="bold">Dossier :</td>
            <td width="35%">#{{ $patient->id }}</td>
        </tr>
        <tr>
            <td class="bold">Né(e) le :</td>
            <td>{{ $patient->date_of_birth->format('d/m/Y') }}</td>
            <td class="bold">Diabète :</td>
            <td>{{ $patient->diabetes_type }}</td>
        </tr>
    </table>

    <div class="section-title">Imagerie Rétinienne</div>
    <div class="image-container">
        <img src="{{ $imagePath }}" class="scan-img">
        <div style="font-size: 10px; margin-top: 5px;">
            {{ $scan->eye_side == 'OD' ? 'Œil Droit (OD)' : 'Œil Gauche (OG)' }} |
            {{ $scan->created_at->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="section-title">Diagnostic & Conclusion</div>
    <div class="diagnosis-box">
        <p><span class="bold">Diagnostic :</span> {{ $scan->final_diagnosis }}</p>
        <p style="font-size: 9px; color: #666; margin-top: 5px;">(IA : {{ $scan->ai_result }} -
            {{ $scan->ai_confidence }}%)</p>
    </div>


    <div class="section-title">Prescription</div>
    <div style="padding: 5px; background: #fff; border: 1px solid #eee; min-height: 40px;">
        @if ($scan->prescription)
            {!! nl2br(e($scan->prescription)) !!}
        @endif
    </div>


    <div class="signature-section">
        <div class="signature-box">

            @if (isset($signatureData))
                <img src="{{ $signatureData }}" class="signature-img">
            @else
                <div style="height: 60px;"></div>
            @endif

            <div class="signature-line"></div>
            <div style="font-size: 10px;">Dr. {{ $doctor->name }}</div>
        </div>
    </div>

    <div class="footer">
        @ Document généré par RetinaScan - Validé électroniquement.
    </div>

</body>

</html>
