<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">NIK</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->nik }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-md font-medium">Nama</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->nama }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Tempat Lahir</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->tempat_lahir }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Tanggal Lahir</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->tanggal_lahir->format('Y-m-d') }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Jenis Kelamin</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->jenis_kelamin }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Pekerjaan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->pekerjaan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Status Hubungan Dalam Keluarga</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_hubungan_dalam_keluarga }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Status Perkawinan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_perkawinan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Kota</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->kota }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Kecamatan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->kecamatan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Desa/Kelurahan</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->desa }}</p>
    </div>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
        <div class="flex flex-col justify-center">
            <h3 class="md:text-xl text-sm font-medium">RT</h3>
            <p class="select-none md:text-md text-sm">{{ $citizen->nomor_rt }}</p>
        </div>
        <div class="flex flex-col justify-center">
            <h3 class="md:text-xl text-sm font-medium">RW</h3>
            <p class="select-none md:text-md text-sm">{{ $citizen->nomor_rw }}</p>
        </div>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Pendidikan Terakhir</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->pendidikan_terakhir }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Golongan Darah</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->golongan_darah }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Agama</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->agama }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Status Penduduk</h3>
        <p class="select-none md:text-md text-sm">{{ $citizen->status_penduduk }}</p>
    </div>
</div>
<div class="mt-8 flex h-96 items-center justify-center bg-gray-100 font-sans">
    <div class="bg-white border border-gray-300 w-full h-full rounded-md flex flex-col items-center">
        <div id="image-container" class="flex justify-center items-center w-full h-full overflow-hidden">
            <img id="image" class="w-full h-3/4 object-contain" alt="foto_ktp" src="{{ asset($citizen->foto_ktp) }}"/>
        </div>
    </div>
</div>
