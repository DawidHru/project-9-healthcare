<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

<<<<<<< HEAD
=======
        <!-- Date of Birth -->
        <div class="mt-4">
            <label for="date_of_birth">Date of Birth</label>
            <input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" required>
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <label for="gender">Gender</label>
            <select id="gender" class="block mt-1 w-full" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <label for="address">Address</label>
            <input id="address" class="block mt-1 w-full" type="text" name="address" required>
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <label for="phone">Phone</label>
            <input id="phone" class="block mt-1 w-full" type="text" name="phone" required>
        </div>

        <!-- Emergency Contact -->
        <div class="mt-4">
            <label for="emergency_contact">Emergency Contact</label>
            <input id="emergency_contact" class="block mt-1 w-full" type="text" name="emergency_contact" required>
        </div>

        <!-- Blood Type -->
        <div class="mt-4">
            <label for="blood_type">Blood Type</label>
            <select id="blood_type" class="block mt-1 w-full" name="blood_type" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>

>>>>>>> 9d34e96279d375f00c4c2fe3a3b91f47593c3fb0
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
