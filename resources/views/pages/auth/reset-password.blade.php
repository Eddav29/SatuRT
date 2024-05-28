<x-auth-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->

        <x-text-input id="email" class="block mt-1 w-full" type="hidden" name="email" :value="old('email', $request->email)" required
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
