<div class="bg-[#E8F1FF] px-2 py-4">
    <h1 class="font-bold text-2xl">Data Kepala Keluarga</h1>
</div>

<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="nik" :value="__('NIK')" required="true" />

        <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" placeholder="350*************"
            required />
        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nama" :value="__('Nama')" required="true" />

        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" placeholder="Nama"
            required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" required="true" />

        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir"
            placeholder="Tempat Lahir" required />
        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" required="true" />

        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
            placeholder="tanggal lahir" required />
        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" required="true" />
        <select name="jenis_kelamin" id="jenis_kelamin"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($jenis_kelamin as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="pekerjaan" :value="__('Pekerjaan')" required="true" />

        <x-text-input id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" placeholder="Pekerjaan"
            required />
        <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="status_hubungan_dalam_keluarga" :value="__('Status Hubungan Dalam Keluarga')" required="true" />
        <select name="status_hubungan_dalam_keluarga" id="status_hubungan_dalam_keluarga"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($status_keluarga as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('status_hubungan_dalam_keluarga')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" required="true" />
        <select name="status_perkawinan" id="status_perkawinan"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($status_perkawinan as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2" />
    </div>
</div>
{{--  --}}
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="kota" :value="__('Kota')" required="true" />

        <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota" placeholder="Kota"
            required />
        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="kecamatan" :value="__('Kecamatan')" required="true" />

        <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" placeholder="kecamatan"
            required />
        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="desa" :value="__('Desa/Kelurahan')" required="true" />

        <x-text-input id="desa" class="block mt-1 w-full" type="text" name="desa"
            placeholder="Desa/Kelurahan" required />
        <x-input-error :messages="$errors->get('desa')" class="mt-2" />
    </div>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
        <div>
            <x-input-label for="nomor_rw" :value="__('RW')" required="true" />

            <x-text-input id="nomor_rw" class="block mt-1 w-full" type="number" min="1" name="nomor_rw" placeholder="RW"
                required />
            <x-input-error :messages="$errors->get('nomor_rw')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="nomor_rt" :value="__('RT')" required="true" />

            <x-text-input id="nomor_rt" class="block mt-1 w-full" type="number" min="1" name="nomor_rt" placeholder="RT"
                required />
            <x-input-error :messages="$errors->get('nomor_rt')" class="mt-2" />
        </div>
    </div>
</div>

{{--  --}}

<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="pendidikan_terakhir" :value="__('Pendidikan Terakhir')" required="true" />
        <select name="pendidikan_terakhir" id="pendidikan_terakhir"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($pendidikan_terakhir as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('pendidikan_terakhir')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="golongan_darah" :value="__('Golongan Darah')" required="true" />
        <select name="golongan_darah" id="golongan_darah"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($golongan_darah as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="agama" :value="__('Agama')" required="true" />
        <select name="agama" id="agama"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($agama as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('agama')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="status_penduduk" :value="__('Status Penduduk')" required="true" />
        <select name="status_penduduk" id="status_penduduk"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>--Select--</option>
            @foreach ($status_penduduk as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('status_penduduk')" class="mt-2" />
    </div>
</div>
<div class="mt-8 flex h-96 items-center justify-center bg-gray-100 font-sans">
    <div class="bg-white border border-gray-300 w-full h-full rounded-md flex flex-col items-center">
        <label for="foto_ktp" ondragover="allowDrop(event)" ondrop="dropFile(event)"
            class="mx-auto cursor-pointer flex flex-col items-center justify-center text-center h-full w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <div id="file-preview-container" class="hidden mt-8 flex justify-center">
                <img id="file-preview" class="w-64 h-auto" alt="File Preview" />
            </div>
            <h2 class="mt-4 text-xl font-medium text-gray-700 tracking-wide">Payment File</h2>
            <p class="mt-2 text-gray-500 tracking-wide">Upload or drag & drop your file SVG, PNG, JPG, or GIF.</p>
            <input id="foto_ktp" name="foto_ktp" type="file" class="hidden"
                onchange="renderFile(this.files)" />
        </label>
        <x-input-error :messages="$errors->get('foto_ktp')" class="mt-2" />
    </div>
</div>

@push('scripts')
    <script>
        function allowDrop(event) {
            event.preventDefault();
        }

        function dropFile(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            renderFile(files);
        }

        function renderFile(files) {
            const file = files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const filePreview = document.getElementById('file-preview');
                filePreview.src = e.target.result;
                document.getElementById('file-preview-container').classList.remove('hidden');
            }

            reader.readAsDataURL(file);
            console.log(document.getElementById('file-preview').src);
        }
    </script>
@endpush
