<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-md font-medium">Pemilik</h3>
        <p class="select-none md:text-md text-sm">{{ $user->penduduk->nama }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Nomor Induk Kependudukan</h3>
        <p class="select-none md:text-md text-sm">{{ $user->penduduk->nik }}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Email</h3>
        <p class="select-none md:text-md text-sm">{{ $user->email }}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Username</h3>
        <p class="select-none md:text-md text-sm">{{ $user->username}}</p>
    </div>
</div>
<div class="mt-8 grid sm:grid-cols-2 grid-cols-1 gap-6">
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Role</h3>
        <p class="select-none md:text-md text-sm">{{ $user->role->role_name}}</p>
    </div>
    <div class="flex flex-col justify-center">
        <h3 class="md:text-xl text-sm font-medium">Password</h3>
        <p class="select-none md:text-md text-sm">********</p>
    </div>
</div>
