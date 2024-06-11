<footer class="w-full max-w-7xl mx-auto lg:mt-40">
    <div class="grid grid-rows-2 grid-cols-1 lg:flex lg:flex-col mt-10 gap-5">
        <div class="grid grid-rows-3 gap-5 lg:grid-rows-1 lg:grid-cols-3 lg:gap-10">
            <div class="flex flex-col gap-2">
                <h1 class="text-[1.618rem]/[2.618rem] font-bold">Tentang</h1>
                <p class="text-[1rem]/[1.618rem]">RT 001 RW 003: Komunitas yang bersatu, aman, dan bersahabat. Bersama,
                    kita
                    menciptakan lingkungan yang
                    harmonis dan inklusif. Bergabunglah dengan kami untuk merasakan kehangatan dan dukungan dari
                    tetangga-tetangga kita.</p>
            </div>
            <div class="flex flex-col gap-2">
                <h1 class="text-[1.618rem]/[2.618rem] font-bold">Tautan</h1>
                <ul class="text-[1rem]/[1.618rem]">
                    <li><a href="/berita" class="hover:underline">Berita</a></li>
                    <li><a href="/usaha" class="hover:underline">Usaha</a></li>
                </ul>
            </div>
            <div class="flex flex-col gap-2">
                <h1 class="text-[1.618rem]/[2.618rem] font-bold">Kontak</h1>
                <p class="text-[1rem]/[1.618rem]">Jalan Terusan Piranha Atas no 14 gang 2 RT 01 RW 03, Tunjungsekar, Lowokwaru, Malang</p>
                <div class="flex gap-3">
                    <x-heroicon-o-phone class="w-6 h-6" />
                    <p class="text-[1rem]/[1.618rem]">+62 812 3456 7890</p>
                </div>
                <div class="flex gap-3">
                    <x-heroicon-o-envelope class="w-6 h-6" />
                    <p class="text-[1rem]/[1.618rem]">saturt@example.com</p>
                </div>
            </div>
        </div>
        <div class=" flex justify-end relative lg:h-96">
            <img src="{{ asset('assets/images/undraw_with_love_re_1q3m.svg') }}" alt=""
                class="absolute -right-28 h-full transform -scale-x-100">
        </div>
    </div>
    <hr class="border-1 border-gray-300">
    <div class="flex flex-col items-center justify-center p-5">
        <p class="text-[1rem]/[1.618rem]">Powered by
            <a href="https://icons8.com/" class="font-bold text-green-500 underline">Icons8</a> |
            <a href="https://www.freepik.com/" class="font-bold text-azure-blue underline">Freepik</a> |
            <a href="https://heroicons.com" class="font-bold text-purple-500 underline">Heroicons</a>
        </p>
        <p class="text-[1rem]/[1.618rem]">&copy; {{ date('Y') }}. All Rights Reserved</p>
        <p class="text-[1rem]/[1.618rem]">Version 1.0.0</p>
    </div>
</footer>
