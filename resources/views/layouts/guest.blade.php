<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Barangay JobLink') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-slate-900 antialiased">
    <div class="min-h-screen bg-slate-100 lg:grid lg:grid-cols-2">

        <!-- Left Branding Panel -->
        <div
            class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-emerald-700 via-emerald-800 to-blue-900 text-white">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-white"></div>
                <div class="absolute bottom-10 right-10 h-96 w-96 rounded-full bg-white"></div>
            </div>

            <div class="relative z-10 flex flex-col justify-between p-14 w-full">
                <div>
                    <div class="flex items-center gap-4">
                        <div
                            class="h-20 w-16 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center font-black text-2xl shadow-lg">
                            <img src="{{ asset('images/logo1.png') }}" class="h-full w-full object-cover">
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold tracking-tight">
                                Barangay JobLink
                            </h1>
                            <p class="text-sm text-emerald-100">
                                Community-Based Job Referral System
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-emerald-200 font-semibold mb-4">
                        SDG 1 · No Poverty
                    </p>

                    <h2 class="text-4xl font-black leading-tight mb-5">
                        Connecting local workers to local opportunities.
                    </h2>

                    <p class="text-lg text-emerald-50 max-w-xl leading-relaxed">
                        A simple web-based platform that helps low-income residents find nearby jobs
                        while helping barangay staff monitor employment outcomes.
                    </p>

                    <div class="grid grid-cols-3 gap-4 mt-10">
                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-2xl font-bold">Fast</p>
                            <p class="text-sm text-emerald-100">Job referrals</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-2xl font-bold">Fair</p>
                            <p class="text-sm text-emerald-100">Application tracking</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <p class="text-2xl font-bold">Local</p>
                            <p class="text-sm text-emerald-100">Barangay-based</p>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-emerald-100">
                    Davao del Norte State College · IT223 Advanced Database System
                </div>
            </div>
        </div>

        <!-- Right Auth Panel -->
        <div class="flex min-h-screen items-center justify-center px-6 py-10">
            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-8">
                    <div
                        class="mx-auto h-20 w-16 rounded-2xl bg-gradient-to-br from-green-600 to-green-700 text-white flex items-center justify-center font-black text-2xl shadow-lg">
                        <img src="{{ asset('images/logo1.png') }}" class="h-full w-full object-cover">
                    </div>

                    <h1 class="mt-4 text-2xl font-bold text-slate-900">
                        Barangay JobLink
                    </h1>

                    <p class="text-sm text-slate-500">
                        Community-Based Job Referral System
                    </p>
                </div>

                <div class="bg-white/95 backdrop-blur border border-slate-200 rounded-3xl shadow-xl p-8">
                    {{ $slot }}
                </div>

                <p class="text-center text-xs text-slate-500 mt-6">
                    Secure login powered by Laravel Authentication
                </p>
            </div>
        </div>
    </div>
</body>

</html>