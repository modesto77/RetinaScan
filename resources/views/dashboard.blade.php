<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard - Dr.') }} {{ Auth::user()->name }}
            </h2>
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm font-medium">{{ __('Tracked Patients') }}</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $totPatients }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500 flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full mr-4 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm font-medium">{{ __('AI Analyses') }}</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $totScans }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500 flex items-center">
                    <div class="p-3 bg-red-100 rounded-full mr-4 text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm font-medium">{{ __('Critical Cases') }}</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $criticalScans }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <a href="{{ route('patients.create') }}" class="group relative bg-white overflow-hidden rounded-xl shadow-lg border border-gray-100 hover:border-blue-500 transition-all duration-300 hover:-translate-y-1">
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-full text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">{{ __('New Patient') }}</h3>
                        </div>
                        <p class="text-gray-500 mb-6">{{ __('Patient has no file? Create their record here before exam.') }}</p>
                        <span class="text-blue-600 font-semibold group-hover:underline">{{ __('Create File') }} &rarr;</span>
                    </div>
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                </a>

                <div class="relative bg-gradient-to-br from-purple-600 to-indigo-700 overflow-hidden rounded-xl shadow-lg text-white">
                    <div class="p-8 relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="bg-white/20 p-3 rounded-full text-white mr-4 backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold">{{ __('Scan a Patient') }}</h3>
                        </div>
                        <p class="text-purple-100 mb-6">{{ __('Use the search bar below to find an existing file and launch AI analysis.') }}</p>
                        
                        <div class="relative">
                            <input type="text" id="quickSearch" placeholder="{{ __('Search name, first name...') }}" class="w-full pl-10 pr-4 py-3 rounded-lg text-gray-900 border-none focus:ring-2 focus:ring-purple-300 shadow-lg" autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 -mb-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">{{ __('Recent Patients') }}</h4>
                    
                    @if($patients->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <p>{{ __('No patient recorded.') }}</p>
                            <a href="{{ route('patients.create') }}" class="text-blue-600 hover:underline">{{ __('Start by adding one.') }}</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold tracking-wider">
                                        <th class="px-5 py-3 text-left">{{ __('Identity') }}</th>
                                        <th class="px-5 py-3 text-center">{{ __('Age') }}</th>
                                        <th class="px-5 py-3 text-center">{{ __('Diabetes') }}</th>
                                        <th class="px-5 py-3 text-center">{{ __('AI Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="patientsTableBody">
                                    @foreach($patients as $patient)
                                    <tr class="patient-row hover:bg-purple-50 transition border-b border-gray-100">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold uppercase">
                                                    {{ substr($patient->last_name, 0, 1) }}{{ substr($patient->first_name, 0, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 font-bold whitespace-no-wrap search-target">
                                                        {{ $patient->last_name }} {{ $patient->first_name }}
                                                    </p>
                                                    <p class="text-gray-500 text-xs">{{ __($patient->gender) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm">
                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} {{ __('years') }}
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="px-3 py-1 font-semibold text-xs leading-tight {{ $patient->diabetes_type == 'Type 1' ? 'text-red-700 bg-red-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                                {{ $patient->diabetes_type ? __($patient->diabetes_type) : __('Undefined') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <a href="{{ route('patients.show', $patient->id) }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition shadow-md transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ __('SCAN') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 px-4">
                            {{ $patients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('quickSearch');
            const tableRows = document.querySelectorAll('.patient-row');

            if(searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();

                    tableRows.forEach(row => {
                        const name = row.querySelector('.search-target').textContent.toLowerCase();
                        if (name.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>