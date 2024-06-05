<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">NIK</h3>
        <p class="md:text-md text-sm">{{ Str::mask($citizen->nik ?? '', '*', 6) }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-md font-semibold">Nama</h3>
        <p class="md:text-md text-sm">{{ $citizen->nama }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Tempat Lahir</h3>
        <p class="md:text-md text-sm">{{ $citizen->tempat_lahir }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Tanggal Lahir</h3>
        <p class="md:text-md text-sm">{{ $citizen->tanggal_lahir->format('Y-m-d') }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Jenis Kelamin</h3>
        <p class="md:text-md text-sm">{{ $citizen->jenis_kelamin }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Pekerjaan</h3>
        <p class="md:text-md text-sm">{{ $citizen->pekerjaan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Status Hubungan Dalam Keluarga</h3>
        <p class="md:text-md text-sm">{{ $citizen->status_hubungan_dalam_keluarga }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Status Perkawinan</h3>
        <p class="md:text-md text-sm">{{ $citizen->status_perkawinan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Kota</h3>
        <p class="md:text-md text-sm">{{ $citizen->kota }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Kecamatan</h3>
        <p class="md:text-md text-sm">{{ $citizen->kecamatan }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Desa/Kelurahan</h3>
        <p class="md:text-md text-sm">{{ $citizen->desa }}</p>
    </div>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
        <div class="flex flex-col justify-center">
            <h3 class="select-none md:text-lg text-sm font-semibold">RT</h3>
            <p class="md:text-md text-sm">{{ $citizen->nomor_rt }}</p>
        </div>
        <div class="flex flex-col justify-center">
            <h3 class="select-none md:text-lg text-sm font-semibold">RW</h3>
            <p class="md:text-md text-sm">{{ $citizen->nomor_rw }}</p>
        </div>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Pendidikan Terakhir</h3>
        <p class="md:text-md text-sm">{{ $citizen->pendidikan_terakhir }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Golongan Darah</h3>
        <p class="md:text-md text-sm">{{ $citizen->golongan_darah }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Agama</h3>
        <p class="md:text-md text-sm">{{ $citizen->agama }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Status Penduduk</h3>
        <p class="md:text-md text-sm">{{ $citizen->status_penduduk }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none md:text-lg text-sm font-semibold">Status</h3>
        <p class="md:text-md text-sm">{{ $citizen->status_kehidupan }}</p>
    </div>
</div>
<div class="mt-8 =f px-5">
    <div>
        <h3 class="select-none md:text-lg text-sm font-semibold">Foto Kartu Tanda Penduduk</h3>
        <x-image-preview :file="is_null($citizen->foto_ktp) ? null : route('storage.ktp', $citizen->foto_ktp)"  />
    </div>
</div>
