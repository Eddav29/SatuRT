<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Nomor Kartu Keluarga</h3>
        <p class="select-none md:text-md text-sm">{{ $familyCard->nomor_kartu_keluarga }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-md font-medium">Kota</h3>
        <p class="select-none md:text-md text-sm">{{ $familyCard->kota }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Kecamatan</h3>
        <p class="select-none md:text-md text-sm">{{ $familyCard->kecamatan }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Desa/Kelurahan</h3>
        <p class="select-none md:text-md text-sm">{{ $familyCard->desa }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">RT</h3>
        <p class="select-none md:text-md text-sm">{{ $familyCard->nomor_rt }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">RW</h3>
        <p class="select-none md:text-md text-sm">{{ $familyCard->nomor_rw }}</p>
    </div>
</div>
