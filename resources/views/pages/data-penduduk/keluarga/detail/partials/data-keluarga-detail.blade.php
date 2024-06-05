<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">Nomor Kartu Keluarga</h3>
        <p class="md:text-md text-sm">{{ Str::mask($familyCard->nomor_kartu_keluarga ?? '', '*', 6) }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-md sm:text-lg font-semibold">Kota</h3>
        <p class="md:text-md text-sm">{{ $familyCard->kota }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">Kecamatan</h3>
        <p class="md:text-md text-sm">{{ $familyCard->kecamatan }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">Desa/Kelurahan</h3>
        <p class="md:text-md text-sm">{{ $familyCard->desa }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">RT</h3>
        <p class="md:text-md text-sm">{{ $familyCard->nomor_rt }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">RW</h3>
        <p class="md:text-md text-sm">{{ $familyCard->nomor_rw }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">Kode Pos</h3>
        <p class="md:text-md text-sm">{{ $familyCard->kode_pos}}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="select-none text-sm sm:text-lg font-semibold">Alamat</h3>
        <p class="md:text-md text-sm">{{ $familyCard->alamat }}</p>
    </div>
</div>
