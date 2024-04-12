<div class="bg-[#E8F1FF] px-2 py-4">
    <h1 class="font-bold text-2xl">Data Keluarga</h1>
</div>

<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="nomor_kartu_keluarga" :value="__('Nomor Kartu Keluarga')" required="true" />

        <x-text-input id="nomor_kartu_keluarga" class="block mt-1 w-full" type="text" name="nomor_kartu_keluarga"
            placeholder="350*************" required />
        <x-input-error :messages="$errors->get('nomor_kartu_keluarga')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kota" :value="__('Kota')" required="true" />

        <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota"
            placeholder="Kota" required />
        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="kecamatan" :value="__('Kecamatan')" required="true" />

        <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan"
            placeholder="kecamatan" required />
        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="desa" :value="__('Desa/Kelurahan')" required="true" />

        <x-text-input id="desa" class="block mt-1 w-full" type="text" name="desa"
            placeholder="Desa/Kelurahan" required />
        <x-input-error :messages="$errors->get('desa')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="nomor_rw" :value="__('RW')" required="true" />

        <x-text-input id="nomor_rw" class="block mt-1 w-full" type="number" min="1" name="nomor_rw"
            placeholder="RW" required />
        <x-input-error :messages="$errors->get('nomor_rw')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nomor_rt" :value="__('RT')" required="true" />

        <x-text-input id="nomor_rt" class="block mt-1 w-full" type="number" min="1" name="nomor_rt"
            placeholder="RT" required />
        <x-input-error :messages="$errors->get('nomor_rt')" class="mt-2" />
    </div>
</div>
