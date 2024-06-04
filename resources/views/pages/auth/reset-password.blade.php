<x-auth-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="flex items-center justify-start">
            <div class="w-20 md:w-24 flex">
                <x-application-logo class="w-auto h-auto text-gray-800 " />
            </div>
        </div>

        <div class="mt-6">
            <h1 class="font-bold text-2xl">Reset Password</h1>
            <p class="font-nomral text-md text-gray-400">Silahkan masukkan password baru anda</p>
        </div>

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->

        <x-input-text id="email" class="block mt-1 w-full" type="hidden" name="email" :value="old('email', $request->email)" required
            autofocus autocomplete="username" />

        <!-- Password -->
        <div class="mt-4">
            <x-input-password name="password" label="Password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-password name="password_confirmation" label="Konfirmasi Password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
