
<section class="fixed h-screen w-full z-[99999] bg-black bg-opacity-30 flex justify-center items-center">
    <div class="bg-white rounded-md max-w-96 w-full">
        <div class="border-b py-4 px-6">
            <h1 class="font-semibold text-xl">Ubah Sandi</h1>
        </div>
        <form action="{{url('/auth/change-password')}}" method="POST">
            @csrf
            @method('PUT')
            <div class="px-8 py-4">
                <div class="mt-4">
                    <p class="text-gray-400 text-sm md:text-md">Silahkan ubah password anda untuk keamanan akun anda.</p>
                </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-input-password name="password" label="Password" />

                </div>

                <!-- Confirm Password -->
                <div class="mt-4 relative">
                        <x-input-password name="password_confirmation" label="Konfirmasi Password" />
                </div>

                <div class="my-4">
                    <button type="submit"
                        class="bg-blue-600 w-full text-white rounded-md px-4 py-2 hover:bg-blue-300">Simpan</button>
                </div>
        </form>
    </div>
</section>
