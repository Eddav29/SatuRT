<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="nik" :value="__('NIK')" required="true" />

        <x-input-text id="nik" class="block mt-1 w-full" type="text" name="nik" placeholder="350*************"
            value="{{ old('nik', isset($citizen) ? $citizen->nik : '') }}" required />
        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nama" :value="__('Nama')" required="true" />

        <x-input-text id="nama" class="block mt-1 w-full" type="text" name="nama" placeholder="Nama"
            value="{{ old('nama', isset($citizen) ? $citizen->nama : '') }}" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" required="true" />

        <x-input-text id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir"
            value="{{ old('tempat_lahir', isset($citizen) ? $citizen->tempat_lahir : '') }}" placeholder="Tempat Lahir"
            required />
        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" required="true" />

        <x-input-text id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
            value="{{ isset($citizen) ? $citizen->tanggal_lahir->format('Y-m-d') : '' }}" placeholder="tanggal lahir"
            required />
        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" required="true" />

        <select name="jenis_kelamin" id="jenis_kelamin"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 text-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @if (!old('jenis_kelamin') || !isset($citizen->jenis_kelamin))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($jenis_kelamin as $value)
                <option value="{{ $value }}" @if ($value == old('jenis_kelamin', isset($citizen) ? $citizen->jenis_kelamin : '')) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="pekerjaan" :value="__('Pekerjaan')" required="true" />

        <x-input-text id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" placeholder="Pekerjaan"
            value="{{ old('pekerjaan', isset($citizen) ? $citizen->pekerjaan : '') }}" required />
        <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="status_hubungan_dalam_keluarga" :value="__('Status Hubungan Dalam Keluarga')" required="true" />
        <select name="status_hubungan_dalam_keluarga" id="status_hubungan_dalam_keluarga"
            class="block mt-1 w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="" selected>--Select--</option>
            @foreach ($status_hubungan_dalam_keluarga as $value)
                <option value="{{ $value }}" @if ($value == old('status_hubungan_dalam_keluarga', isset($citizen) ? $citizen->status_hubungan_dalam_keluarga : '')) selected @endif>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status_hubungan_dalam_keluarga')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" required="true" />
        <select name="status_perkawinan" id="status_perkawinan"
            class="block mt-1 w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

            @if (!old('status_perkawinan') || !isset($citizen->status_perkawinan))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($status_perkawinan as $value)
                <option value="{{ $value }}" @if ($value == old('status_perkawinan', isset($citizen) ? $citizen->status_perkawinan : '')) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2" />
    </div>
</div>

<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="kota" :value="__('Kota')" required="true" />

        <x-input-text id="kota" class="block mt-1 w-full" type="text" name="kota" placeholder="Kota"
            value="{{ old('kota', isset($citizen) ? $citizen->kota : '') }}" required />
        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kecamatan" :value="__('Kecamatan')" required="true" />

        <x-input-text id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" placeholder="kecamatan"
            value="{{ old('kecamatan', isset($citizen) ? $citizen->kecamatan : '') }}" required />
        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="desa" :value="__('Desa/Kelurahan')" required="true" />

        <x-input-text id="desa" class="block mt-1 w-full" type="text" name="desa"
            value="{{ old('desa', isset($citizen) ? $citizen->desa : '') }}" placeholder="Desa/Kelurahan" required />
        <x-input-error :messages="$errors->get('desa')" class="mt-2" />
    </div>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-5">
        <div>
            <x-input-label for="nomor_rw" :value="__('RW')" required="true" />

            <x-input-text id="nomor_rw" class="block mt-1 w-full" type="number" min="1" name="nomor_rw"
                placeholder="RW" value="{{ old('nomor_rw', isset($citizen) ? $citizen->nomor_rw : '') }}" required />
            <x-input-error :messages="$errors->get('nomor_rw')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="nomor_rt" :value="__('RT')" required="true" />

            <x-input-text id="nomor_rt" class="block mt-1 w-full" type="number" min="1" name="nomor_rt"
                placeholder="RT" value="{{ old('nomor_rt', isset($citizen) ? $citizen->nomor_rt : '') }}" required />
            <x-input-error :messages="$errors->get('nomor_rt')" class="mt-2" />
        </div>
    </div>
</div>

<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="pendidikan_terakhir" :value="__('Pendidikan Terakhir')" required="true" />
        <select name="pendidikan_terakhir" id="pendidikan_terakhir"
            class="block mt-1 w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

            @if (!old('pendidikan_terakhir') || !isset($citizen->pendidikan_terakhir))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($pendidikan_terakhir as $value)
                <option value="{{ $value }}" @if ($value == old('pendidikan_terakhir', isset($citizen) ? $citizen->pendidikan_terakhir : '')) selected @endif>
                    {{ $value }}</option>
            @endforeach

        </select>

        <x-input-error :messages="$errors->get('pendidikan_terakhir')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="golongan_darah" :value="__('Golongan Darah')" required="true" />
        <select name="golongan_darah" id="golongan_darah"
            class="block mt-1 w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

            @if (!old('golongan_darah') || !isset($citizen->golongan_darah))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($golongan_darah as $value)
                <option value="{{ $value }}" @if ($value == old('golongan_darah', isset($citizen) ? $citizen->golongan_darah : '')) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="agama" :value="__('Agama')" required="true" />
        <select name="agama" id="agama"
            class="block mt-1 text-sm w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @if (!old('agama') || !isset($citizen->agama))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($agama as $value)
                <option value="{{ $value }}" @if ($value == old('agama', isset($citizen) ? $citizen->agama : '')) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('agama')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="status_penduduk" :value="__('Status Penduduk')" required="true" />
        <select name="status_penduduk" id="status_penduduk"
            class="block mt-1 text-sm w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @if (!old('status_penduduk') || !isset($citizen->status_penduduk))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($status_penduduk as $value)
                <option value="{{ $value }}" @if ($value == old('status_penduduk', isset($citizen) ? $citizen->status_penduduk : '')) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('status_penduduk')" class="mt-2" />
    </div>
</div>


@isset($canCreateAccount)
    @if ($canCreateAccount)
        <div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
            <div class="my-4">
                <x-input-checkbox name="create_account" :checked="false" label="Buatkan akun" />
                <x-input-error :messages="$errors->get('create_account')" class="mt-2" />
            </div>
        </div>
    @endif
@endisset

<div class="mt-5 grid grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="images" :value="__('Foto Kartu Tanda Penduduk')" />
        @isset($citizen->foto_ktp)
            <x-input-file name="images" :accept="$extension" :default="route('storage.ktp', $citizen->foto_ktp)" />
        @else
            <x-input-file name="images" :accept="$extension" />
        @endisset
    </div>
</div>
