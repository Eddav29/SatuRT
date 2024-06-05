<x-profile-layout>
    <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
        <div class="mx-auto flex items-center justify-between lg:hidden w-full">
            <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                <x-heroicon-c-bars-3-center-left />
            </button>
            <div class="lg:hidden" x-data="{ profile: false }">
                <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                    @if (Auth::user()->penduduk->user->profile)
                        <img src="{{ asset('storage/images_storage/account_images/' . Auth::user()->penduduk->user->profile) }}"
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

    {{-- End Header --}}
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                <h1 class="text-2xl font-semibold">Ubah Data Akun</h1>
            </div>

            {{-- Form --}}
            <form action="{{ route('profile.account.post') }}" enctype="multipart/form-data" method="POST">
                @csrf

                <div class="flex flex-col md:grid md:grid-cols-2">
                    <div class="mx-3 my-4 gap-5 flex flex-col font-bold">
                        <div>
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">NIK</div>
                            @error('nik')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input disabled type="text" value="{{ $penduduk->nik }}" placeholder="Masukkan NIK"
                                disabled
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                        <div>
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Nama</div>
                            @error('nama')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="text" value="{{ $penduduk->nama }}" placeholder="Masukkan Nama" disabled
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                        <div>
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Username</div>
                            @error('username')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="text" value="{{ $penduduk->user->username }}" name="username" id="username"
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                        <div>
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Email</div>
                            @error('email')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="text" value="{{ $penduduk->user->email }}" placeholder="Masukkan Email"
                                name="email" id="email"
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                    </div>

                    {{-- Foto Profile --}}
                    <div class="mx-3 my-3 font-bold">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Foto Profile</div>
                        <div>
                            @error('profile')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            @isset($penduduk->user->profile)
                                <x-input-file name="profile" :accept="$extension" :default="route('public', $penduduk->user->profile)" />
                            @else
                                <x-input-file name="profile" :accept="$extension" />
                            @endisset
                        </div>
                    </div>
                </div>



                {{-- Button --}}
                <div class="mt-3 ml-4 flex gap-x-5">
                    <button type="submit"
                        class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                        Simpan
                    </button>
                    <a href="{{ route('profile.account') }}"
                        class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                        Kembali
                    </a>
                </div>

            </form>
            {{-- End Form --}}
        </div>
    </div>

    @push('styles')
    @endpush

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/super-build/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var fileInput = document.getElementById('file_input');
                var pendudukFotoKtp = <?php echo json_encode($penduduk->foto_ktp); ?>;

                if (value === null) {
                    fileInput.value = pendudukFotoKtp;
                }
            });

            const previewImage = () => {
                const fileInput = document.querySelector('#file_input');
                const imagePreview = document.querySelector('#preview-image');
                const filePreview = document.querySelector('#preview-file');

                if (fileInput.files && fileInput.files[0]) {
                    if (fileInput.files[0].type !== 'application/pdf') {
                        !filePreview.classList.contains('hidden') ? filePreview.classList.add('hidden') : '';
                        imagePreview.classList.remove('hidden');
                        imagePreview.classList.add('inline-block', 'py-5');
                    } else {
                        !imagePreview.classList.contains('hidden') ? imagePreview.classList.add('hidden') : '';
                        filePreview.textContent = fileInput.files[0].name;
                        filePreview.classList.remove('hidden');
                    }
                }


                if (fileInput.files[0].type !== 'application/pdf') {
                    const oFReader = new FileReader();
                    oFReader.readAsDataURL(fileInput.files[0]);

                    oFReader.onload = function(oFREvent) {
                        imagePreview.src = oFREvent.target.result;
                    }
                }
            }
        </script>
    @endpush

</x-profile-layout>
