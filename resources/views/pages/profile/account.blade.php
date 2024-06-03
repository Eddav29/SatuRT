<x-profile-layout>
    <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
        <div class="mx-auto flex items-center justify-between lg:hidden w-full">
            <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                <x-heroicon-c-bars-3-center-left />
            </button>
            <div class="lg:hidden" x-data="{ profile: false }">
                <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                    @if (Auth::user()->penduduk->user->profile)
                        <img src="{{ asset('storage/images_storage/' . Auth::user()->penduduk->user->profile) }}"
                            class="h-full w-full object-cover">
                    @else
                        <img src="{{ asset('assets/images/default.png') }}" class="h-full w-full object-cover">
                    @endif
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
            <section>
                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Akun</h1>
                </div>
            </section>

            {{-- Form --}}
            <section>
                <div class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-3">
                    <div>
                        <div class="mt-3">
                            <h5 class="font-semibold">NIK</h5>
                            <p>{{ Str::mask(optional(Auth::user()->penduduk)->nik ?? '', '*', 6) }}</p>
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

                    <div class="font-semibold mt-3  max-h-52">
                        <h5 class="font-semibold">Foto Profile</h5>
                        <x-image-preview :file="is_null(Auth::user()->penduduk->user->profile)
                            ? asset('assets/images/default.png')
                            : route('public', Auth::user()->penduduk->user->profile)" />
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
