<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Patient File:') }} {{ $patient->last_name }} {{ $patient->first_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT') 
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 bg-white border-b border-gray-200">

                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-700 border-b pb-2 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs mr-3">1</span>
                                {{ __('Civil Information') }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">{{ __('Last Name') }}</label>
                                    <input type="text" name="last_name" 
                                           value="{{ old('last_name', $patient->last_name) }}"
                                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">{{ __('First Name') }}</label>
                                    <input type="text" name="first_name" 
                                           value="{{ old('first_name', $patient->first_name) }}"
                                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">{{ __('Date of Birth') }}</label>
                                    <input type="date" name="date_of_birth" 
                                           value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}"
                                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">{{ __('Gender') }}</label>
                                    <select name="gender" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                        <option value="Homme" {{ old('gender', $patient->gender) == 'Homme' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Femme" {{ old('gender', $patient->gender) == 'Femme' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        <option value="Autre" {{ old('gender', $patient->gender) == 'Autre' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block font-medium text-sm text-gray-700">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" 
                                           value="{{ old('phone', $patient->phone) }}"
                                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
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
                                    <label class="block font-medium text-sm text-gray-700">{{ __('Diabetes Type') }}</label>
                                    <select name="diabetes_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                        <option value="Type 2" {{ old('diabetes_type', $patient->diabetes_type) == 'Type 2' ? 'selected' : '' }}>Type 2</option>
                                        <option value="Type 1" {{ old('diabetes_type', $patient->diabetes_type) == 'Type 1' ? 'selected' : '' }}>Type 1</option>
                                        <option value="Gestationnel" {{ old('diabetes_type', $patient->diabetes_type) == 'Gestationnel' ? 'selected' : '' }}>{{ __('Gestational') }}</option>
                                        <option value="Autre" {{ old('diabetes_type', $patient->diabetes_type) == 'Autre' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">{{ __('Diagnosis Year') }}</label>
                                    <input type="number" name="diagnosis_year" 
                                           value="{{ old('diagnosis_year', $patient->diagnosis_year) }}"
                                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                           min="1900" max="{{ date('Y') }}">
                                </div>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">{{ __('Medical History & Observations') }}</label>
                                <textarea name="medical_history" rows="4" 
                                          class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">{{ old('medical_history', $patient->medical_history) }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('patients.show', $patient->id) }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring ring-indigo-300 transition ease-in-out duration-150">
                            {{ __('Update Patient File') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>