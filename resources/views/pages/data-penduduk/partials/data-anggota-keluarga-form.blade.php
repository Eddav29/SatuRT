<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="nik" :value="__('NIK')" required="true" />

        <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" placeholder="350*************"
            value="{{ old('nik', isset($citizen) ? $citizen->nik : '') }}" required />
        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nama" :value="__('Nama')" required="true" />

        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" placeholder="Nama"
            value="{{ old('nama', isset($citizen) ? $citizen->nama : '') }}" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" required="true" />

        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir"
            value="{{ old('tempat_lahir', isset($citizen) ? $citizen->tempat_lahir : '') }}" placeholder="Tempat Lahir"
            required />
        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" required="true" />

        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
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

        <x-text-input id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" placeholder="Pekerjaan"
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

        <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota" placeholder="Kota"
            value="{{ old('kota', isset($citizen) ? $citizen->kota : '') }}" required />
        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kecamatan" :value="__('Kecamatan')" required="true" />

        <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" placeholder="kecamatan"
            value="{{ old('kecamatan', isset($citizen) ? $citizen->kecamatan : '') }}" required />
        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
    </div>
</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="desa" :value="__('Desa/Kelurahan')" required="true" />

        <x-text-input id="desa" class="block mt-1 w-full" type="text" name="desa"
            value="{{ old('desa', isset($citizen) ? $citizen->desa : '') }}" placeholder="Desa/Kelurahan" required />
        <x-input-error :messages="$errors->get('desa')" class="mt-2" />
    </div>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-5">
        <div>
            <x-input-label for="nomor_rw" :value="__('RW')" required="true" />

            <x-text-input id="nomor_rw" class="block mt-1 w-full" type="number" min="1" name="nomor_rw"
                placeholder="RW" value="{{ old('nomor_rw', isset($citizen) ? $citizen->nomor_rw : '') }}" required />
            <x-input-error :messages="$errors->get('nomor_rw')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="nomor_rt" :value="__('RT')" required="true" />

            <x-text-input id="nomor_rt" class="block mt-1 w-full" type="number" min="1" name="nomor_rt"
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

<div class="mt-5 flex items-center justify-center bg-gray-100 font-sans mx-5">
    <div class="bg-white border border-gray-300 w-full h-full rounded-md flex flex-col items-center"
        x-data="{ openImage: false, filePreview: null, offsetX: 0, offsetY: 0, scale: 1, previewImage: null }" x-init="previewImage = $refs.previewImage ">
        <div id="drop-area" class="relative w-full bg-blue-100 py-10" @dragover.prevent
            @drop.prevent="filePreview = URL.createObjectURL($event.dataTransfer.files[0])">
            <input type="file" name="images" id="images" multiple="multiple"
                @change="filePreview = URL.createObjectURL($event.target.files[0])"
                class="absolute top-0 w-full h-full opacity-0 cursor-pointer">
            <div class="flex flex-col justify-center items-center w-full h-full space-y-6">
                <div class="bg-blue-100 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                </div>
                <h3 class="text-md font-normal text-blue-500">Drag &amp; drop files here</h3>
                <span class="text-sm">- OR -</span>
                <label for="images" class="cursor-pointer">
                    <span class="font-bold">Browse</span>
                </label>
            </div>
        </div>
        <div>
            <img @click="openImage = !openImage" :src="filePreview" alt=""
                class="rounded-xl max-h-[30rem] w-full object-contain" draggable="false">
            <div x-show="openImage"
                class="fixed z-[9999999] top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
                <img x-show="openImage" x-ref="previewImage"
                    :src="filePreview" alt="" class="rounded-xl max-w-full max-h-full">
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
                            <button @click="if (scale < 5) {scale += 0.1; previewImage.style.transform = `scale(${scale}) translate(${offsetX}px, ${offsetY}px)`;}"
                                class="bg-white-400 px-3 py-1"><x-heroicon-o-magnifying-glass-plus
                                    class="w-6 h-6 text-black hover:text-gray-600" /></button>
                            <button @click="if (scale > 0.2) { scale -= 0.1; previewImage.style.transform = `scale(${scale}) translate(${offsetX}px, ${offsetY}px)`; }"
                                class="bg-white-400 px-3 py-1"><x-heroicon-o-magnifying-glass-minus
                                    class="w-6 h-6 text-black hover:text-gray-600" /></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-input-error :messages="$errors->get('images')" class="mt-2" />
    </div>
</div>
