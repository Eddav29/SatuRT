<x-auth-layout>

    <div class="flex items-center justify-start">
        <div class="w-20 md:w-24 flex">
            <x-application-logo class="w-auto h-auto text-gray-800 " />
        </div>
    </div>

    <div class="mt-6">
        <h1 class="font-bold text-2xl">Lupa Kata Sandi</h1>
        <p class="font-nomral text-md text-gray-400">Masukkan alamat email Anda dan kami akan mengirimkan tautan reset kata sandi yang akan memungkinkan Anda untuk memilih kata sandi baru.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-input-text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
