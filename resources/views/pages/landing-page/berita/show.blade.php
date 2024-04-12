<x-guest-layout>
    <div class="flex flex-col gap-y-10 w-full max-w-7xl mx-auto">
        <section>
            <div class="flex flex-col gap-y-10">
                <div>
                    <p class="text-[1rem]/[1.618rem]">Diposting pada
                        {{ \Carbon\Carbon::parse($information->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                    </p>
                    <h1 class="text-[1.618rem]/[2.618rem] font-bold">{{ $information->judul_informasi }}</h1>
                    <p class="text-[1rem]/[1.618rem]">{{ $information->jenis_informasi }}</p>
                </div>
                <div>
                    <div class="h-[20rem] lg:h-[80vh] overflow-hidden">
                        <img src="https://source.unsplash.com/random/?nature" alt=""
                            class="w-full h-full object-cover rounded-xl">
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-3 lg:gap-x-5">
                    <div class="flex flex-col gap-y-5 lg:col-span-2">
                        <p class="text-[1rem]/[1.618rem]">{{ $information->isi_informasi }}</p>
                    </div>
                    <div class="max-lg:hidden border-l-2 border-green-light px-4">
                        <div class="flex flex-col gap-y-5">
                            <div class="border-b-2 border-green-light">
                                <h1 class="font-bold text-[1.618rem]/[2.618rem]">Berita Lainnya</h1>
                            </div>
                            <div class="flex flex-col gap-5">
                                @foreach ($otherInformations as $otherInformation)
                                    <a href="{{ route('berita-detail', $otherInformation->informasi_id) }}"
                                        class="lg:max-h-[29rem] group">
                                        <div class="relative h-72 lg:h-[60%]">
                                            <img src="https://source.unsplash.com/random/?market" alt=""
                                                class="rounded-xl w-full h-full object-cover">
                                        </div>
                                        <div class="py-3">
                                            <h1 class="group-hover:underline font-bold text-[1rem]/[1.618rem]">
                                                {{ $otherInformation->judul_informasi }}
                                            </h1>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Other News --}}
        <section class="lg:hidden">
            <div class="mt-10 flex flex-col gap-y-5">
                <div class="border-b-2 border-green-light">
                    <h1 class="font-bold text-[1.618rem]/[2.618rem]">Berita Lainnya</h1>
                </div>
                <div class="grid grid-rows-4 grid-cols-1 gap-5">
                    <a href="#" class="lg:max-h-[29rem] group">
                        <div class="relative h-72 lg:h-[60%]">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl w-full h-full object-cover">
                        </div>
                        <div class="py-3">
                            <h1 class="group-hover:underline font-bold text-[1.618rem]/[2.618rem]">Kerja Bakti Dalam
                                Rangka
                                Pembangunan Jalan
                            </h1>
                        </div>
                    </a>
                    <a href="#" class="lg:max-h-[29rem] group">
                        <div class="relative h-72 lg:h-[60%]">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl w-full h-full object-cover">
                        </div>
                        <div class="py-3">
                            <h1 class="group-hover:underline font-bold text-[1.618rem]/[2.618rem]">Kerja Bakti Dalam
                                Rangka
                                Pembangunan Jalan
                            </h1>
                        </div>
                    </a>
                    <a href="#" class="lg:max-h-[29rem] group">
                        <div class="relative h-72 lg:h-[60%]">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl w-full h-full object-cover">
                        </div>
                        <div class="py-3">
                            <h1 class="group-hover:underline font-bold text-[1.618rem]/[2.618rem]">Kerja Bakti Dalam
                                Rangka
                                Pembangunan Jalan
                            </h1>
                        </div>
                    </a>
                    <a href="#" class="lg:max-h-[29rem] group">
                        <div class="relative h-72 lg:h-[60%]">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl w-full h-full object-cover">
                        </div>
                        <div class="py-3">
                            <h1 class="group-hover:underline font-bold text-[1.618rem]/[2.618rem]">Kerja Bakti Dalam
                                Rangka
                                Pembangunan Jalan
                            </h1>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
    {{-- End Other News --}}
</x-guest-layout>