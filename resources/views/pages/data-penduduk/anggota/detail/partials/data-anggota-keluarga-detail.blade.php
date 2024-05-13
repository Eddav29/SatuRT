<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">NIK</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->nik }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-md font-semibold">Nama</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->nama }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Tempat Lahir</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->tempat_lahir }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Tanggal Lahir</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->tanggal_lahir->format('Y-m-d') }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Jenis Kelamin</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->jenis_kelamin }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Pekerjaan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->pekerjaan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Status Hubungan Dalam Keluarga</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_hubungan_dalam_keluarga }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Status Perkawinan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_perkawinan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Kota</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->kota }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Kecamatan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->kecamatan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Desa/Kelurahan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->desa }}</p>
    </div>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
        <div class="flex flex-col justify-center">
            <h3 class="md:text-lg text-sm font-semibold">RT</h3>
            <p class="select-none md:text-md text-sm">{{ $citizen->nomor_rt }}</p>
        </div>
        <div class="flex flex-col justify-center">
            <h3 class="md:text-lg text-sm font-semibold">RW</h3>
            <p class="select-none md:text-md text-sm">{{ $citizen->nomor_rw }}</p>
        </div>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Pendidikan Terakhir</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->pendidikan_terakhir }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Golongan Darah</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->golongan_darah }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Agama</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->agama }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Status Penduduk</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_penduduk }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Status</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_kehidupan }}</p>
    </div>
</div>
<div class="mt-8 grid grid-cols-1 px-5">
    <h3 class="md:text-lg text-sm font-semibold">Foto KTP</h3>
    <div x-data="{ openImage: false, scale: 1, offsetX: 0, offsetY: 0, filePreview: '{{ asset($citizen->foto_ktp) }}', previewImage: null }" x-init="previewImage = $refs.previewImage">
        <img @click="openImage = !openImage" :src="filePreview" alt=""
            class="rounded-xl max-h-[30rem] w-full object-contain" draggable="false">
        <div x-show="openImage"
            class="fixed z-[9999999] top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
            <img x-show="openImage" x-ref="previewImage" :src="filePreview" alt=""
                class="rounded-xl max-w-full max-h-full">
            <button type="button" @click.prevent="openImage = false" class="absolute top-10 right-10 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 5.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="absolute bottom-0 w-full">
                <div class="flex justify-center ">
                    <div class="rounded-xl bg-white">
                        <button
                            @click="if (scale < 5) {scale += 0.1; previewImage.style.transform = `scale(${scale}) translate(${offsetX}px, ${offsetY}px)`;}"
                            class="bg-white-400 px-3 py-1"><x-heroicon-o-magnifying-glass-plus
                                class="w-6 h-6 text-black hover:text-gray-600" /></button>
                        <button
                            @click="if (scale > 0.2) { scale -= 0.1; previewImage.style.transform = `scale(${scale}) translate(${offsetX}px, ${offsetY}px)`; }"
                            class="bg-white-400 px-3 py-1"><x-heroicon-o-magnifying-glass-minus
                                class="w-6 h-6 text-black hover:text-gray-600" /></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
