<x-profile-layout>
    <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
        <div class="mx-auto flex items-center justify-between lg:hidden w-full">
            <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                <x-heroicon-c-bars-3-center-left />
            </button>
            <div class="lg:hidden" x-data="{ profile: false }">
                <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                    <img class="h-full w-full object-cover"
                        src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}" alt="">
                </div>
                <div class="absolute right-11 p-2" :class="profile ? 'block' : 'hidden'">
                    <div class="flex flex-col overflow-hidden rounded-lg ">
                        <x-nav-button :class="'text-red-500'" :href="route('logout')">
                            {{ __('Logout') }}
                        </x-nav-button>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Akun</h1>
                </div>
            </section>
            {{-- End header --}}

            {{-- Form --}}
            <section>
                <div class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-3">
                    <div>
                        <div class="mt-3">
                            <h5 class="font-semibold">NIK</h5>
                            <p>{{ Auth::user()->penduduk->nik ?? '' }}</p>
                        </div>
                        <div class="mt-3">
                            <h5 class="font-semibold">Nama</h5>
                            <p>{{ Auth::user()->penduduk->nama ?? '' }}</p>
                        </div>
                        <div class="mt-3">
                            <h5 class="font-semibold">Email</h5>
                            <p>{{ Auth::user()->penduduk->user->email ?? '' }}</p>
                        </div>
                    </div>

                    <div>
                        <div class="mt-3">
                            <h5 class="font-semibold">Username</h5>
                            <p>{{ Auth::user()->penduduk->user->username ?? '' }}</p>
                        </div>
                        <div class="mt-3">
                            <h5 class="font-semibold">Role</h5>
                            <p>{{ Auth::user()->penduduk->user->role->role_name ?? '' }}</p>
                        </div>
                    </div>

                    <div class="font-semibold mt-3">
                        <h5 class="font-semibold">Foto Profile</h5>
                        <img src="{{ asset('storage/images_storage/account_images/' .  Auth::user()->penduduk->user->profile)}}"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                        </img>
                    </div>
                </div>
            </section>

            <section style="text-align: center" class="mt-3">
                <a href="{{ route('profile.account.get', Auth::user()->penduduk->penduduk_id ?? '') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Ubah Data
                </a>
            </section>

            {{-- End Form --}}
        </div>
    </div>
</x-profile-layout>
