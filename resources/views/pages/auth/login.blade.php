<x-auth-layout>
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <h1 class="font-bold">Terjadi Kesalahan!</h1>
            <p class="block sm:inline">{{ session('error') }}</p>
        </div>

    @elseif (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <h1 class="font-bold">Berhasil!</h1>
            <p class="block sm:inline">{{ session('success') }}</p>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}" >
        @csrf

        <div class="flex items-center justify-start">
            <div class="w-20 md:w-24 flex">
                <x-application-logo class="w-auto h-auto text-gray-800 " />
            </div>
        </div>

        <div class="mt-6">
            <h1 class="font-bold text-2xl">Selamat Datang</h1>
            <p class="font-nomral text-md text-gray-400">Ayo masuk satuRT sekarang!</p>
        </div>

        <div class="mt-8">
            <x-input-label for="username" :value="__('Username')" required="true" />
            <x-input-text id="username" class="block mt-1 w-full" type="text" name="username" placeholder="350*************" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />

        </div>

        <div class="mt-4">
            <x-input-password name="password" label="Password" :required="true" />
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600  hover:text-blue-900 rounded-md" href="{{ route('password.request') }}">
                    {{ __('Lupa Kata Sandi?') }}
                </a>
            @endif

            </div>
            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="w-full">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
    </form>
</x-auth-layout>
