<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Analysis:') }} {{ $patient->last_name }} {{ $patient->first_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="mb-6 bg-blue-50 p-4 rounded-lg flex items-center">
                    <div class="text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-700">{{ $patient->last_name }} {{ $patient->first_name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ __($patient->gender) }} - {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} {{ __('years') }} - {{ $patient->diabetes_type }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('scans.store', $patient->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-bold text-gray-700 mb-2">{{ __('Which eye are you analyzing?') }}</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center space-x-2 cursor-pointer bg-gray-100 p-4 rounded hover:bg-gray-200 transition w-full justify-center">
                                <input type="radio" name="eye_side" value="OD" class="form-radio text-indigo-600 h-5 w-5" checked>
                                <span class="font-bold">{{ __('Right Eye (OD)') }}</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer bg-gray-100 p-4 rounded hover:bg-gray-200 transition w-full justify-center">
                                <input type="radio" name="eye_side" value="OG" class="form-radio text-indigo-600 h-5 w-5">
                                <span class="font-bold">{{ __('Left Eye (OS)') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold text-gray-700 mb-2">{{ __('Fundus Image') }}</label>
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-2 relative h-64 flex justify-center items-center bg-gray-50 hover:bg-gray-100 transition overflow-hidden">
                            
                            <input type="file" id="imageInput" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" required accept="image/*">
                            
                            <div id="uploadPlaceholder" class="text-center pointer-events-none">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-1 text-sm text-gray-600">{{ __('Click or drag image here') }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ __('PNG, JPG (Max 10MB)') }}</p>
                            </div>

                            <div id="imagePreview" class="absolute inset-0 w-full h-full hidden bg-white flex justify-center items-center">
                                <img id="previewImg" src="" alt="Aperçu" class="max-h-full max-w-full object-contain p-2">
                                <div class="absolute bottom-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                    {{ __('Click to change') }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('patients.show', $patient->id) }}" class="text-gray-600 underline mr-6 self-center">{{ __('Cancel') }}</a>
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded shadow hover:bg-indigo-700 transition transform hover:scale-105">
                            {{ __('Start AI Analysis') }} 🚀
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const placeholder = document.getElementById('uploadPlaceholder');
            const previewContainer = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                previewImg.src = "";
                placeholder.classList.remove('hidden');
                previewContainer.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>