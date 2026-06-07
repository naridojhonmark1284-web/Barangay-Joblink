<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Left Side -->
            <div class="flex items-center">

                <!-- Brand -->
                <a href="{{ route('dashboard') }}" class="flex` items-center gap-3">
                    <div
                        class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-600 to-blue-700 text-white flex items-center justify-center font-black shadow">
                        <img src="{{ asset('images/logo2.png') }}" alt="JobLink Logo">
                    </div>

                    <div class="hidden sm:block leading-tight">
                        <div class="font-bold text-slate-900">
                            Barangay JobLink
                        </div>
                        <div class="text-xs text-slate-500">
                            Job Referral System
                        </div>
                    </div>
                </a>

                <!-- Desktop Links -->
                <div class="hidden sm:flex sm:ml-10 sm:space-x-8">
                    @if (auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                            Reports
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'employer')
                        <x-nav-link :href="route('employer.dashboard')" :active="request()->routeIs('employer.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('employer.jobs.create')"
                            :active="request()->routeIs('employer.jobs.create')">
                            Post Job
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'seeker')
                        <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                            Available Jobs
                        </x-nav-link>

                        <x-nav-link :href="route('applications.mine')" :active="request()->routeIs('applications.mine')">
                            My Applications
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">

                <!-- Role Badge -->
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border
                    @if(auth()->user()->role === 'admin')
                        bg-purple-50 text-purple-700 border-purple-100
                    @elseif(auth()->user()->role === 'employer')
                        bg-blue-50 text-blue-700 border-blue-100
                    @else
                        bg-emerald-50 text-emerald-700 border-emerald-100
                    @endif
                ">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition">
                            <div
                                class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <div class="text-left">
                                <div class="font-semibold">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>

                            <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-slate-200 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                    Reports
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->role === 'employer')
                <x-responsive-nav-link :href="route('employer.dashboard')"
                    :active="request()->routeIs('employer.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('employer.jobs.create')"
                    :active="request()->routeIs('employer.jobs.create')">
                    Post Job
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->role === 'seeker')
                <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                    Available Jobs
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('applications.mine')" :active="request()->routeIs('applications.mine')">
                    My Applications
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">
                    {{ auth()->user()->name }}
                </div>

                <div class="font-medium text-sm text-slate-500">
                    {{ auth()->user()->email }}
                </div>

                <div class="mt-2">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>