<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="nik" :value="__('Nomor Induk Kependudukan')" required="true" />

        <x-input-text id="nik" class="block mt-1 w-full" type="text" name="nik"
            value="{{ old('nik', isset($user) ? $user->penduduk->nik : '') }}" placeholder="350*************"
            required />
        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />

        <x-input-text id="email" class="block mt-1 w-full" type="email" name="email"
            value="{{ old('email', isset($user) ? $user->email : '') }}" placeholder="test@example.com" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>

<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        <x-input-label for="username" :value="__('Username')" required="true" />

        <x-input-text id="username" class="block mt-1 w-full" type="text" name="username" placeholder="Username"
            value="{{ old('username', isset($user) ? $user->username : '') }}" required />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <div x-data="{ selectedRoleId: '{{ old('role_id', isset($user->role->role_id) ? $user->role->role_id : '') }}', showWarning: false }">
        <x-input-label for="role" :value="__('Role')" :required="true" />
        <select name="role_id" id="role_id"
            x-on:change="
                selectedRoleName = $event.target.selectedOptions[0].text;
                showWarning = (selectedRoleName === 'Ketua RT');
                if (showWarning) {
                    pushNotification('warning', 'Semua hak akses akan ditransfer!');
                }
            "
            x-bind:value="selectedRoleId"
            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 bg-transparent focus:ring-opacity-50 text-sm">
            <option value="" selected>--Select--</option>
            @foreach ($role as $item)
                <option class="text-xs" value="{{ $item->role_id }}"
                    {{ old('role_id', isset($user->item->role_id) ? $user->item->role_id : '') == $item->role_id ? 'selected' : '' }}>
                    {{ $item->role_name }}
                </option>
            @endforeach
        </select>

        <p x-show="showWarning" class="text-red-500" x-cloak>Peringatan: Semua hak akses akan ditransfer!</p>

        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

</div>
<div class="mt-5 grid sm:grid-cols-2 grid-cols-1 gap-5 px-5">
    <div>
        @isset($user)
            <x-input-password name="password" label="Password" :required="false" />
        @else
            <x-input-password name="password" label="Password" :required="true" />
        @endisset
    </div>
    <div>
        @isset($user)
            <x-input-password name="password_confirmation" label="Konfirmasi Password" :required="false" />
        @else
            <x-input-password name="password_confirmation" label="Konfirmasi Password" :required="true" />
        @endisset
    </div>
</div>
