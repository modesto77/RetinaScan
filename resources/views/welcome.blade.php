<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'sans-serif'],
                        },
                        colors: {
                            medical: {
                                50: '#eff6ff',
                                100: '#dbeafe',
                                500: '#3b82f6', // Bleu standard
                                600: '#2563eb', // Bleu action
                                700: '#1d4ed8', // Bleu foncé
                                900: '#1e3a8a', // Bleu nuit
                            }
                        }
                    }
                }
            }
        </script>
    @endif
</head>

<body class="font-sans antialiased text-gray-800 bg-white selection:bg-blue-500 selection:text-white">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer group" onclick="window.scrollTo(0,0)">
                    <div class="bg-blue-600 p-2 rounded-lg shadow-lg group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">{{ __('RetinaScan') }}</span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home"
                        class="text-gray-600 hover:text-blue-600 transition font-medium text-sm uppercase tracking-wide">{{ __('Home') }}</a>
                    <a href="#solution"
                        class="text-gray-600 hover:text-blue-600 transition font-medium text-sm uppercase tracking-wide">{{ __('The Solution') }}</a>
                    <a href="#about"
                        class="text-gray-600 hover:text-blue-600 transition font-medium text-sm uppercase tracking-wide">{{ __('About') }}</a>
                    <a href="#contact"
                        class="text-gray-600 hover:text-blue-600 transition font-medium text-sm uppercase tracking-wide">{{ __('Contact') }}</a>
                    
                    <!-- Bouton de changement de langue -->
                    <a href="{{ route('lang.switch', app()->getLocale() == 'fr' ? 'en' : 'fr') }}" 
                       class="px-3 py-1 border border-gray-300 rounded text-sm font-bold text-gray-600 hover:bg-gray-100 transition">
                        {{ app()->getLocale() == 'fr' ? 'EN' : 'FR' }}
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-full text-sm font-bold hover:bg-blue-700 transition shadow-md flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                                {{ __('My Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-bold text-gray-700 hover:text-blue-600 transition px-4">{{ __('Login') }}</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="hidden sm:inline-block px-5 py-2.5 bg-gray-900 text-white rounded-full text-sm font-bold hover:bg-black transition shadow-md">
                                    {{ __('Doctor Registration') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section id="home"
        class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div
                    class="inline-flex items-center px-3 py-1 rounded-full border border-blue-200 bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest mb-6">
                    {{ __('New Version 2.0 with AI') }}
                </div>
                <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-gray-900 mb-6 leading-tight">
                    {{ __('AI at the service of') }} <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ __('Visual Health') }}</span>
                </h1>
                <p class="mt-6 text-xl text-gray-600 mb-10 leading-relaxed">
                    {{ __('RetinaScan uses advanced') }} <strong>{{ __('Deep Learning') }}</strong> {{ __('models to assist') }}
                    {{ __('ophthalmologists in the early detection of') }} <strong>{{ __('diabetic retinopathy') }}</strong>.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-xl hover:shadow-blue-500/30 flex items-center justify-center">
                            {{ __('Access Analysis') }}
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-xl hover:shadow-blue-500/30 flex items-center justify-center">
                            {{ __('Start Diagnosis') }}
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="#solution"
                            class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold text-lg hover:bg-gray-50 transition flex items-center justify-center">
                            {{ __('How it works?') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none opacity-40">
            <div
                class="absolute top-20 left-10 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob">
            </div>
            <div
                class="absolute top-20 right-10 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-32 left-1/2 w-96 h-96 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000">
            </div>
        </div>
    </section>

    <section id="solution" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ __('State-of-the-art technology') }}</h2>
                <p class="mt-4 text-xl text-gray-500">{{ __('An optimized workflow for doctors, from scan to PDF report.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div
                    class="group relative bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-100 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('Image Analysis') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Upload a fundus image and get within seconds a classification of the disease stage (0 to 4) with a confidence score.') }}
                    </p>
                </div>

                <div
                    class="group relative bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-100 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('Medical Reports') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Automatically generate professional PDF reports, including diagnosis, analyzed image and your electronic signature.') }}
                    </p>
                </div>

                <div
                    class="group relative bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-cyan-100 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('Secure Data') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Each doctor has their own secure space. Patient records are isolated and protected from unauthorized access.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-blue-50/50 skew-x-12 translate-x-20 z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-blue-600 font-bold tracking-wide uppercase text-sm mb-3">{{ __('Pathology & Issues') }}</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ __('What is Diabetic Retinopathy?') }}
                </h3>
                <p class="text-lg text-gray-600 leading-relaxed">
                    {{ __('The leading cause of preventable blindness worldwide, this diabetes complication affects the blood vessels in the retina.') }}
                    <span class="font-bold text-blue-700">{{ __('Without early screening, lesions are irreversible.') }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">

                <div class="relative group">
                    <div
                        class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl opacity-20 group-hover:opacity-40 blur transition duration-500">
                    </div>
                    <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                        <div class="grid grid-cols-2 h-80">
                            <div class="relative h-full border-r-2 border-white">
                                <img src="{{ asset('imageSaine.png') }}" alt="{{ __('Healthy Retina') }}"
                                    class="absolute inset-0 w-full h-full object-cover">
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-green-600/90 text-white text-center py-2 text-sm font-bold backdrop-blur-sm">
                                    ✓ {{ __('Healthy Retina') }}
                                </div>
                            </div>
                            <div class="relative h-full">
                                <img src="{{ asset('image.png') }}" alt="{{ __('Diseased Retina') }}"
                                    class="absolute inset-0 w-full h-full object-cover hue-rotate-15 contrast-125">
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-red-600/90 text-white text-center py-2 text-sm font-bold backdrop-blur-sm">
                                    ⚠ {{ __('Advanced Retinopathy') }}
                                </div>

                                <div class="absolute top-1/3 left-1/4 w-4 h-4 bg-red-500 rounded-full animate-ping">
                                </div>
                                <div
                                    class="absolute top-1/3 left-1/4 w-4 h-4 bg-red-500 border-2 border-white rounded-full">
                                </div>

                                <div
                                    class="absolute bottom-1/3 right-1/3 w-3 h-3 bg-red-500 rounded-full animate-ping delay-700">
                                </div>
                                <div
                                    class="absolute bottom-1/3 right-1/3 w-3 h-3 bg-red-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-center italic">{{ __('Visual simulation of retinal lesions (microaneurysms and hemorrhages).') }}</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mt-1">
                            1</div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-900">{{ __('Chronic Hyperglycemia') }}</h4>
                            <p class="text-gray-600 mt-1">{{ __('Excess sugar in the blood weakens the walls of the retinal capillaries, leading to loss of integrity.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mt-1">
                            2</div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-900">{{ __('Hemorrhages & Exudates') }}</h4>
                            <p class="text-gray-600 mt-1">{{ __('Micro-bleeding and lipid deposits appear (the yellow and red spots detected by our AI).') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold mt-1">
                            3</div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-900">{{ __('Risk of Blindness') }}</h4>
                            <p class="text-gray-600 mt-1">{{ __('Without treatment, new fragile vessels form (proliferation), leading to retinal detachment.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-3xl p-8 md:p-12 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">{{ __('The 5 Stages detected by RetinaScan') }}</h3>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-green-500">
                        <div class="text-lg font-bold text-gray-900 mb-1">{{ __('Stage 0') }}</div>
                        <div class="text-xs font-bold text-green-600 uppercase mb-2">{{ __('Absent') }}</div>
                        <p class="text-xs text-gray-500">{{ __('Normal retina, no visible signs.') }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-blue-400">
                        <div class="text-lg font-bold text-gray-900 mb-1">{{ __('Stage 1') }}</div>
                        <div class="text-xs font-bold text-blue-500 uppercase mb-2">{{ __('Mild') }}</div>
                        <p class="text-xs text-gray-500">{{ __('Presence of isolated microaneurysms.') }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-yellow-400">
                        <div class="text-lg font-bold text-gray-900 mb-1">{{ __('Stage 2') }}</div>
                        <div class="text-xs font-bold text-yellow-600 uppercase mb-2">{{ __('Moderate') }}</div>
                        <p class="text-xs text-gray-500">{{ __('More numerous hemorrhages.') }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-orange-500">
                        <div class="text-lg font-bold text-gray-900 mb-1">{{ __('Stage 3') }}</div>
                        <div class="text-xs font-bold text-orange-600 uppercase mb-2">{{ __('Severe') }}</div>
                        <p class="text-xs text-gray-500">{{ __('Multiple pre-proliferative signs.') }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-red-600">
                        <div class="text-lg font-bold text-gray-900 mb-1">{{ __('Stage 4') }}</div>
                        <div class="text-xs font-bold text-red-600 uppercase mb-2">{{ __('Proliferative') }}</div>
                        <p class="text-xs text-gray-500">{{ __('Neovascularization, imminent risk.') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <span class="block text-4xl font-extrabold text-blue-600">463 M</span>
                    <span class="text-sm text-gray-500 font-medium">{{ __('Diabetics worldwide') }}</span>
                </div>
                <div>
                    <span class="block text-4xl font-extrabold text-blue-600">1 {{ __('in') }} 3</span>
                    <span class="text-sm text-gray-500 font-medium">{{ __('Will develop retinopathy') }}</span>
                </div>
                <div>
                    <span class="block text-4xl font-extrabold text-blue-600">95%</span>
                    <span class="text-sm text-gray-500 font-medium">{{ __('Preventable if detected early') }}</span>
                </div>
            </div>

        </div>
    </section>

    <section id="contact" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Contact & Support') }}</h2>
                    <p class="text-gray-600 mb-8 text-lg">
                        {{ __('You are a healthcare institution or a practitioner and want to integrate RetinaScan? Our team is at your disposal.') }}
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ __('Email') }}</h4>
                                <p class="text-gray-600">contact@retinascan.med</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ __('Address') }}</h4>
                                <p class="text-gray-600">{{ __('Health Technology Hub, Casablanca') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl">
                    <form action="#" class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-1">{{ __('Doctor / Clinic Name') }}</label>
                            <input type="text" id="name"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="{{ __('Dr. ...') }}">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">{{ __('Professional Email') }}</label>
                            <input type="email" id="email"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="contact@clinic.com">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-bold text-gray-700 mb-1">{{ __('Message') }}</label>
                            <textarea id="message" rows="4"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="{{ __('Demo request...') }}"></textarea>
                        </div>

                        <button type="button"
                            class="w-full py-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition transform hover:-translate-y-0.5 shadow-lg">
                            {{ __('Send Request') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-white py-12 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 flex items-center gap-2">
                    <div class="bg-blue-600 p-1.5 rounded-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gray-900">{{ __('RetinaScan') }}</span>
                </div>
                <div class="flex space-x-8 text-sm font-medium">
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition">{{ __('Legal Notice') }}</a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition">{{ __('Health Data Privacy') }}</a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition">{{ __('Support') }}</a>
                </div>
            </div>
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} RetinaScan Project. {{ __('All rights reserved.') }}
            </div>
        </div>
    </footer>

</body>

</html>