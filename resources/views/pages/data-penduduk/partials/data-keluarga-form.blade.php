

<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="nomor_kartu_keluarga" :value="__('Nomor Kartu Keluarga')" required="true" />

        <x-text-input id="nomor_kartu_keluarga" class="block mt-1 w-full" type="text" name="nomor_kartu_keluarga"
            value="{{ old('nomor_kartu_keluarga', isset($familyCard) ? $familyCard->nomor_kartu_keluarga : '') }}"
            placeholder="350*************" required />
        <x-input-error :messages="$errors->get('nomor_kartu_keluarga')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kk_kota" :value="__('Kota')" required="true" />

        <x-text-input id="kk_kota" class="block mt-1 w-full" type="text" name="kk_kota"
            value="{{ old('kk_kota', isset($familyCard) ? $familyCard->kota : '') }}"
            placeholder="Kota" required />
        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="kk_kecamatan" :value="__('Kecamatan')" required="true" />

        <x-text-input id="kk_kecamatan" class="block mt-1 w-full" type="text" name="kk_kecamatan"
            value="{{ old('kk_kecamatan', isset($familyCard) ? $familyCard->kecamatan : '') }}"
            placeholder="Kecamatan" required />
        <x-input-error :messages="$errors->get('kk_kecamatan')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kk_desa" :value="__('Desa/Kelurahan')" required="true" />

        <x-text-input id="kk_desa" class="block mt-1 w-full" type="text" name="kk_desa"
            value="{{ old('kk_desa', isset($familyCard) ? $familyCard->desa : '') }}"
            placeholder="Desa/Kelurahan" required />
        <x-input-error :messages="$errors->get('kk_desa')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="kk_nomor_rw" :value="__('RW')" required="true" />

        <x-text-input id="kk_nomor_rw" class="block mt-1 w-full" type="number" min="1" name="kk_nomor_rw"
            value="{{ old('kk_nomor_rw', isset($familyCard) ? $familyCard->nomor_rw : '') }}"
            placeholder="RW" required />
        <x-input-error :messages="$errors->get('kk_nomor_rw')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kk_nomor_rt" :value="__('RT')" required="true" />

        <x-text-input id="kk_nomor_rt" class="block mt-1 w-full" type="number" min="1" name="kk_nomor_rt"
            value="{{ old('kk_nomor_rt', isset($familyCard) ? $familyCard->nomor_rt : '') }}"
            placeholder="RT" required />
        <x-input-error :messages="$errors->get('kk_nomor_rt')" class="mt-2" />
    </div>
</div>