<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-md font-semibold">Pemilik</h3>
        <p class="select-none md:text-md text-sm">{{ $user->penduduk->nama }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Nomor Induk Kependudukan</h3>
        <p class="select-none md:text-md text-sm">{{ $user->penduduk->nik }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Email</h3>
        <p class="select-none md:text-md text-sm">{{ $user->email }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Username</h3>
        <p class="select-none md:text-md text-sm">{{ $user->username}}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6 px-5">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Role</h3>
        <p class="select-none md:text-md text-sm">{{ $user->role->role_name}}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-lg text-sm font-semibold">Password</h3>
        <p class="select-none md:text-md text-sm">********</p>
    </div>
</div>
