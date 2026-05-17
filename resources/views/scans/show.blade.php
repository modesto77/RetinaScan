<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Analysis:') }} {{ $scan->patient->last_name }} {{ $scan->patient->first_name }}
            </h2>
            <a href="{{ route('patients.show', $scan->patient_id) }}" class="text-sm text-gray-500 hover:text-gray-900">
                &larr; {{ __('Back to patient file') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 h-screen max-h-[90vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="flex flex-col lg:flex-row gap-6 h-full">

                <div class="lg:w-2/3 flex flex-col gap-4">

                    <div
                        class="bg-black rounded-lg shadow-2xl overflow-hidden relative flex items-center justify-center group flex-grow h-full">
                        <img src="{{ asset('storage/' . $scan->image_path) }}" alt="Fond d'oeil"
                            class="max-h-full max-w-full object-contain transition-transform duration-500 hover:scale-110 cursor-zoom-in">

                        <div
                            class="absolute top-4 left-4 bg-black/50 text-white px-3 py-1 rounded-full backdrop-blur-sm border border-white/20">
                            {{ $scan->eye_side == 'OD' ? __('Right Eye') : __('Left Eye') }}
                        </div>
                        <div class="absolute bottom-4 left-4 text-gray-400 text-xs">
                            {{ __('Scanned on') }} {{ $scan->created_at->format('d/m/Y') }} {{ __('at') }}
                            {{ $scan->created_at->format('H:i') }}
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200" x-data="{ open: false }">

                        <button @click="open = !open" type="button"
                            class="flex items-center text-sm text-gray-600 hover:text-indigo-600 font-bold transition w-full justify-between"
                            id="toggleBtn">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                {{ __('Image error? Replace file') }}
                            </span>
                            <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" class="mt-4 pt-4 border-t border-gray-100" style="display: none;"
                            id="replaceForm">
                            <form action="{{ route('scans.updateImage', $scan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="flex items-center gap-4">
                                    <div class="flex-grow">
                                        <label
                                            class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('New image') }}</label>
                                        <input type="file" name="image" required
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>

                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-indigo-700 transition mt-5">
                                        {{ __('Upload') }}
                                    </button>
                                </div>
                                <p class="text-xs text-red-500 mt-2 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    {{ __('Warning: AI analysis will be reset.') }}
                                </p>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="lg:w-1/3 flex flex-col gap-6 overflow-y-auto">

                    <div
                        class="bg-white p-6 rounded-lg shadow-md border-t-4 {{ __($scan->ai_result) ? 'border-purple-600' : 'border-gray-300' }}">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">
                                {{ __('Artificial Intelligence Analysis') }}</h3>

                            <form action="{{ route('scans.analyze', $scan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-indigo-600 transition"
                                    title="{{ __('Relaunch analysis') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @if ($scan->ai_result)
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-2xl font-bold text-gray-800">{{ __($scan->ai_result) }}</span>
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-bold">
                                    {{ $scan->ai_confidence }}% {{ __('Confidence') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">
                                {{ __('Automatic detection based on Deep Learning model.') }}
                            </p>
                        @else
                            <div class="flex items-center text-orange-500 animate-pulse">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ __('Analysis pending...') }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">
                                {{ __('The Python script has not processed this image yet.') }}
                            </p>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex-grow">
                        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-4">
                            {{ __('Clinical Validation') }}
                        </h3>

                        <form action="{{ route('scans.update', $scan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label
                                    class="block font-bold text-gray-700 text-sm mb-2">{{ __('Final Diagnosis') }}</label>
                                <select name="final_diagnosis"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Select...') }}</option>
                                    <option value="Pas de Rétinopathie"
                                        {{ $scan->final_diagnosis == 'Pas de Rétinopathie' ? 'selected' : '' }}>
                                        {{ __('No Retinopathy (Healthy)') }}</option>
                                    <option value="Légère" {{ $scan->final_diagnosis == 'Légère' ? 'selected' : '' }}>
                                        {{ __('Mild Retinopathy') }}</option>
                                    <option value="Modérée"
                                        {{ $scan->final_diagnosis == 'Modérée' ? 'selected' : '' }}>
                                        {{ __('Moderate Retinopathy') }}</option>
                                    <option value="Sévère" {{ $scan->final_diagnosis == 'Sévère' ? 'selected' : '' }}>
                                        {{ __('Severe Retinopathy') }}</option>
                                    <option value="Proliférante"
                                        {{ $scan->final_diagnosis == 'Proliférante' ? 'selected' : '' }}>
                                        {{ __('Proliferative Retinopathy') }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block font-bold text-gray-700 text-sm mb-2">{{ __('Prescription / Treatment') }}</label>

                                @if ($scan->suggested_treatment && !$scan->prescription)
                                    <div class="mb-2 bg-blue-50 border border-blue-100 rounded-md p-3 flex items-start gap-3"
                                        id="suggestionBox">
                                        <div class="text-blue-500 mt-0.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-grow">
                                            <span
                                                class="text-xs font-bold text-blue-600 uppercase tracking-wide">{{ __('Protocol Suggestion') }}</span>
                                            <p class="text-sm text-gray-700 mt-1" id="suggestionText">
                                                {{ $scan->suggested_treatment }}</p>
                                        </div>

                                        <button type="button" onclick="applySuggestion()"
                                            class="text-xs bg-white border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white px-2 py-1 rounded transition shadow-sm font-semibold">
                                            {{ __('Use') }}
                                        </button>
                                    </div>
                                @endif

                                <textarea name="prescription" id="prescriptionField" rows="3"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="{{ __('Ex: Laser, injection, monitoring...') }}">{{ $scan->prescription }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label
                                    class="block font-bold text-gray-700 text-sm mb-2">{{ __('Private Notes') }}</label>
                                <textarea name="doctor_notes" rows="2" class="w-full border-gray-300 rounded-md shadow-sm bg-yellow-50"
                                    placeholder="{{ __('Notes visible only to you') }}">{{ $scan->doctor_notes }}</textarea>
                            </div>

                            <button type="submit"
                                class="w-full bg-indigo-600 text-white font-bold py-3 rounded-md hover:bg-indigo-700 transition">
                                {{ __('Validate & Save') }}
                            </button>
                        </form>
                    </div>
                    @if ($scan->status == 'valide')
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm mt-6">

                            <h3 class="text-gray-800 font-bold mb-2 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                                {{__('Validate & Sign')}}
                            </h3>

                            <p class="text-sm text-gray-500 mb-4 text-center">
                                {{__('Please sign below to generate the official PDF report.')}}
                            </p>

                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 relative mx-auto max-w-md">
                                <canvas id="signature-canvas"
                                    class="w-full h-48 cursor-crosshair touch-none"></canvas>

                                <div
                                    class="absolute bottom-2 right-2 text-xs text-gray-400 pointer-events-none select-none">
                                    {{__('Sign here (Mouse or Finger)')}}
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-4 max-w-md mx-auto">
                                <button type="button" id="clear-signature"
                                    class="text-sm text-red-500 hover:text-red-700 underline decoration-red-500/30">
                                    {{__('Clear / Restart')}}
                                </button>

                                <form id="signature-form" action="{{ route('scans.pdf', $scan->id) }}"
                                    method="POST">
                                    @csrf

                                    <input type="hidden" name="signature" id="signature-input">
                                    <div class="flex flex-col items-center gap-3 w-full sm:w-auto">

                                        <div class="relative w-full sm:w-auto">
                                            <select name="format"
                                                class="block w-full sm:w-64 border-gray-300 bg-white text-gray-700 py-2.5 px-4 pr-8 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition ease-in-out duration-150 cursor-pointer">
                                                <option value="pdf">{{__('📄 PDF Format (Recommended)')}}</option>
                                                <option value="image">{{__('🖼️ Image Format (JPG)')}}</option>
                                            </select>
                                        </div>

                                        <button type="button" id="save-signature"
                                            class="w-full sm:w-64 inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">

                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12">
                                                </path>
                                            </svg>

                                            {{__('Validate & Download')}}
                                        </button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
    </div>
    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var canvas = document.getElementById('signature-canvas');
                var form = document.getElementById('signature-form');
                var input = document.getElementById('signature-input');
                var clearBtn = document.getElementById('clear-signature');
                var saveBtn = document.getElementById('save-signature');

                if (canvas) {
                    // 1. Initialisation du Pad
                    // On gère le redimensionnement pour éviter le flou sur écran rétina
                    function resizeCanvas() {
                        var ratio = Math.max(window.devicePixelRatio || 1, 1);
                        canvas.width = canvas.offsetWidth * ratio;
                        canvas.height = canvas.offsetHeight * ratio;
                        canvas.getContext("2d").scale(ratio, ratio);
                    }

                    // Appel au chargement et au redimensionnement de la fenêtre
                    window.onresize = resizeCanvas;
                    resizeCanvas();

                    var signaturePad = new SignaturePad(canvas, {
                        backgroundColor: 'rgba(255, 255, 255, 0)', // Fond transparent
                        penColor: "rgb(0, 0, 0)" // Encre noire
                    });

                    // 2. Bouton Effacer
                    clearBtn.addEventListener('click', function() {
                        signaturePad.clear();
                    });

                    // 3. Bouton Valider
                    saveBtn.addEventListener('click', function() {
                        if (signaturePad.isEmpty()) {
                            alert(`{{__('Please sign before downloading the report.')}}`);
                        } else {
                            // On récupère l'image en Base64
                            var data = signaturePad.toDataURL('image/png');
                            // On la met dans l'input caché
                            input.value = data;
                            // On soumet le formulaire
                            form.submit();

                            // Petit effet visuel optionnel
                            saveBtn.innerText = "{{__('Generating...')}}";
                            saveBtn.disabled = true;

                            // On réactive le bouton après quelques secondes (au cas où le téléchargement échoue)
                            setTimeout(() => {
                                saveBtn.innerText = "{{__('Validate & Download')}}";
                                saveBtn.disabled = false;
                            }, 5000);
                        }
                    });
                }
            });
        </script>
        <script>
            function applySuggestion() {
                var text = document.getElementById('suggestionText').innerText;
                var field = document.getElementById('prescriptionField');
                field.value = text;

                // Optionnel : masquer la suggestion après clic pour faire propre
                // document.getElementById('suggestionBox').style.display = 'none';
            }
        </script>
    @endsection
</x-app-layout>
