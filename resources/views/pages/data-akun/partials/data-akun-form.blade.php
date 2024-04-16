<div class="mt-8 grid grid-cols-1 gap-6">
    <div>
        <x-input-label for="nama" :value="__('Pemilik')" required="true" />

        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" placeholder="Nama"
            value="{{ old('nama', isset($user) ? $user->penduduk->nama : '') }}" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="nik" :value="__('Nomor Induk Kependudukan')" required="true" />

        <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik"
            value="{{ old('nik', isset($user) ? $user->penduduk->nik : '') }}" placeholder="350*************"
            required />
        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" required="true" />

        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
            value="{{ old('email', isset($user) ? $user->email : '') }}" placeholder="test@example.com" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>

<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="username" :value="__('Username')" required="true" />

        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" placeholder="Username"
            value="{{ old('username', isset($user) ? $user->username : '') }}" required />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="role" :value="__('Jenis Kelamin')" required="true" />

        <select name="role_id" id="role_id"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @if (!old('role_id') || !isset($user->role->role_id))
                <option value="" selected>--Select--</option>
            @endif

            @foreach ($role as $item)
                <option value="{{ $item->role_id }}"
                    {{ old('role_id', isset($user) ? $user->role->role_id : '') == $item->role_id ? 'selected' : '' }}>
                    {{ $item->role_name }}
                </option>
            @endforeach

        </select>

        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div>
        <x-input-label for="password" :value="__('Password')" required="true" />

        <input class="rounded-xl border-gray-300 ring-blue-500  shadow-sm block mt-1 w-full" id="password"
            type="password" name="password" placeholder="Password" value=""
            @if (!isset($user)) required @endif>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" required="true" />

        <input class="rounded-xl border-gray-300 ring-blue-500  shadow-sm block mt-1 w-full" id="pa_confirmationssword"
            type="password" name="password_confirmation" placeholder="Password" value=""
            @if (!isset($user)) required @endif>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
</div>
