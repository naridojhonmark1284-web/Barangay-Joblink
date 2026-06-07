<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-black text-slate-900">
            Create Account
        </h2>
        <p class="text-sm text-slate-500 mt-1">
            Register as a job seeker or local employer.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ accountType: @js(old('account_type', $defaultType ?? 'seeker')) }">
        @csrf

        <!-- Account Type -->
        <div>
            <x-input-label for="account_type" value="Account Type" />

            <select
                id="account_type"
                name="account_type"
                x-model="accountType"
                class="block mt-1 w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                required
            >
                <option value="seeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>

            <x-input-error :messages="$errors->get('account_type')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                class="block mt-1 w-full rounded-2xl"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Passwords -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input
                    id="password"
                    class="block mt-1 w-full rounded-2xl"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input
                    id="password_confirmation"
                    class="block mt-1 w-full rounded-2xl"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Job Seeker Fields -->
        <div x-show="accountType === 'seeker'" class="mt-6 p-5 rounded-3xl bg-emerald-50 border border-emerald-100">
            <h3 class="font-bold text-emerald-900">
                Job Seeker Profile
            </h3>

            <p class="text-sm text-emerald-700 mt-1">
                Enter your basic information for job applications.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="first_name" value="First Name" />
                    <x-text-input
                        id="first_name"
                        class="block mt-1 w-full rounded-2xl"
                        type="text"
                        name="first_name"
                        :value="old('first_name')"
                    />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="last_name" value="Last Name" />
                    <x-text-input
                        id="last_name"
                        class="block mt-1 w-full rounded-2xl"
                        type="text"
                        name="last_name"
                        :value="old('last_name')"
                    />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="barangay_zone_id" value="Barangay Zone / Purok" />

                <select
                    id="barangay_zone_id"
                    name="barangay_zone_id"
                    class="block mt-1 w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                >
                    <option value="">-- Select Zone --</option>

                    @foreach ($zones as $zone)
                        <option value="{{ $zone->id }}" @selected(old('barangay_zone_id') == $zone->id)>
                            {{ $zone->zone_name }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('barangay_zone_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="seeker_contact_number" value="Contact Number" />
                <x-text-input
                    id="seeker_contact_number"
                    class="block mt-1 w-full rounded-2xl"
                    type="text"
                    name="seeker_contact_number"
                    :value="old('seeker_contact_number')"
                />
                <x-input-error :messages="$errors->get('seeker_contact_number')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="address" value="Address" />
                <textarea
                    id="address"
                    name="address"
                    rows="2"
                    class="block mt-1 w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                >{{ old('address') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <x-input-label for="education_level" value="Education Level" />
                    <x-text-input
                        id="education_level"
                        class="block mt-1 w-full rounded-2xl"
                        type="text"
                        name="education_level"
                        :value="old('education_level')"
                        placeholder="High School Graduate"
                    />
                    <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="years_experience" value="Years Experience" />
                    <x-text-input
                        id="years_experience"
                        class="block mt-1 w-full rounded-2xl"
                        type="number"
                        name="years_experience"
                        :value="old('years_experience', 0)"
                        min="0"
                    />
                    <x-input-error :messages="$errors->get('years_experience')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="preferred_daily_wage" value="Preferred Daily Wage" />
                    <x-text-input
                        id="preferred_daily_wage"
                        class="block mt-1 w-full rounded-2xl"
                        type="number"
                        step="0.01"
                        name="preferred_daily_wage"
                        :value="old('preferred_daily_wage')"
                    />
                    <x-input-error :messages="$errors->get('preferred_daily_wage')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Employer Fields -->
        <div x-show="accountType === 'employer'" class="mt-6 p-5 rounded-3xl bg-blue-50 border border-blue-100">
            <h3 class="font-bold text-blue-900">
                Employer Profile
            </h3>

            <p class="text-sm text-blue-700 mt-1">
                Register your business so you can post job opportunities.
            </p>

            <div class="mt-4">
                <x-input-label for="business_name" value="Business Name" />
                <x-text-input
                    id="business_name"
                    class="block mt-1 w-full rounded-2xl"
                    type="text"
                    name="business_name"
                    :value="old('business_name')"
                />
                <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="business_type" value="Business Type" />
                <x-text-input
                    id="business_type"
                    class="block mt-1 w-full rounded-2xl"
                    type="text"
                    name="business_type"
                    :value="old('business_type')"
                    placeholder="Construction, Food Service, Agriculture..."
                />
                <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="contact_person" value="Contact Person" />
                <x-text-input
                    id="contact_person"
                    class="block mt-1 w-full rounded-2xl"
                    type="text"
                    name="contact_person"
                    :value="old('contact_person')"
                />
                <x-input-error :messages="$errors->get('contact_person')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="employer_contact_number" value="Contact Number" />
                <x-text-input
                    id="employer_contact_number"
                    class="block mt-1 w-full rounded-2xl"
                    type="text"
                    name="employer_contact_number"
                    :value="old('employer_contact_number')"
                />
                <x-input-error :messages="$errors->get('employer_contact_number')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="business_address" value="Business Address" />
                <textarea
                    id="business_address"
                    name="business_address"
                    rows="2"
                    class="block mt-1 w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >{{ old('business_address') }}</textarea>
                <x-input-error :messages="$errors->get('business_address')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a
                class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                href="{{ route('login') }}"
            >
                Already registered?
            </a>

            <x-primary-button class="ms-4 bg-emerald-600 hover:bg-emerald-700 rounded-xl">
                Create Account
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>