<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Patient File') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">{{ __('Warning') }}</p>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 bg-white border-b border-gray-200">
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-700 border-b pb-2 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs mr-3">1</span>
                                {{ __('Civil Information') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700" for="last_name">{{ __('Last Name') }}</label>
                                    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                           id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autofocus placeholder="{{ __('Ex: Smith') }}">
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700" for="first_name">{{ __('First Name') }}</label>
                                    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                           id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required placeholder="{{ __('Ex: John') }}">
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700" for="date_of_birth">{{ __('Date of Birth') }}</label>
                                    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                           id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700" for="gender">{{ __('Gender') }}</label>
                                    <select name="gender" id="gender" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                        <option value="Homme" {{ old('gender') == 'Homme' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Femme" {{ old('gender') == 'Femme' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        <option value="Autre" {{ old('gender') == 'Autre' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block font-medium text-sm text-gray-700" for="phone">{{ __('Phone') }}</label>
                                    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                           id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="06 XX XX XX XX">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-700 border-b pb-2 mb-6 flex items-center">
                                <span class="bg-purple-100 text-purple-600 py-1 px-3 rounded-full text-xs mr-3">2</span>
                                {{ __('Medical Context (Retinopathy)') }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700" for="diabetes_type">{{ __('Diabetes Type') }}</label>
                                    <select name="diabetes_type" id="diabetes_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                        <option value="Type 2" selected>Type 2</option>
                                        <option value="Type 1">Type 1</option>
                                        <option value="Gestationnel">{{ __('Gestational') }}</option>
                                        <option value="Autre">{{ __('Other') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700" for="diagnosis_year">{{ __('Diagnosis Year') }}</label>
                                    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                           id="diagnosis_year" type="number" name="diagnosis_year" value="{{ old('diagnosis_year') }}" 
                                           placeholder="Ex: 2010" min="1900" max="{{ date('Y') }}">
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Diabetes seniority is a key risk factor.') }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="medical_history">{{ __('Medical History & Observations') }}</label>
                                <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                          id="medical_history" name="medical_history" rows="4" 
                                          placeholder="{{ __('Note current treatments here (Insulin, OAD...), hypertension, cholesterol or other eye conditions.') }}">{{ old('medical_history') }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Save Patient') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>