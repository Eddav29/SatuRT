<x-guest-layout>
    {{-- @dd($informations) --}}
    <div class="flex flex-col gap-y-10 w-full max-w-7xl mx-auto">
        {{-- Search Section --}}
        <section class="lg:hidden">
            <div>
                <form action="{{ route('berita') }}" class="w-full relative">
                    @if (request('jfsi'))
                        <input type="hidden" name="jfsi" value="{{ request('jfsi') }}">
                    @endif
                    <input type="text" name="search" id="searchFieldMobile" placeholder="Cari Berita"
                        class="w-full py-5 rounded-lg outline-none ring-0 border-0 focus:ring-1 focus:ring-green-light">
                    <button type="submit">
                        <x-heroicon-o-magnifying-glass class="w-8 h-8 absolute top-1/2 right-3 -translate-y-1/2" />
                    </button>
                </form>
            </div>
        </section>
        {{-- End Search Section --}}

        {{-- New News --}}
        <section>
            <a href="{{ route('berita-detail', $newInformation->informasi_id) }}" class="group">
                <div class="relative h-72 lg:h-[85vh]">
                    <img src="{{ 'storage/information_images/' . $newInformation->thumbnail_url ?? '' }}" alt=""
                        class="rounded-xl w-full h-full object-cover">
                    <div
                        class="absolute bottom-14 left-3 lg:bottom-20 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                        <x-heroicon-o-calendar-days class="w-6 h-6" />
                        <p class="text-[1rem]/[1.618rem]">
                            {{ $newInformation->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div
                        class="absolute top-3 right-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-green-light/70 backdrop-blur-3xl flex gap-3">
                        <p class="text-[1rem]/[1.618rem]">
                            Informasi Baru
                        </p>
                    </div>
                    <div class="absolute bottom-3 text-soft-snow left-3 z-10 text-[1.618rem]/[2.618rem] font-semibold">
                        <h1 class="mix-blend-exclusion group-hover:underline lg:text-[2.618rem]/[3.618rem]">
                            {{ $newInformation->judul_informasi }}</h1>
                    </div>
                </div>
            </a>
        </section>
        {{-- End New News --}}

        {{-- Group News --}}
        <section>
            <div class="overflow-hidden">
                <form action="{{ route('berita') }}" class="w-full overflow-x-auto no-scrollbar">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <ul class="flex flex-nowrap w-max gap-4">
                        <li>
                            <button type="submit" name="jfsi" value="Semua"
                                class="inline-block cursor-pointer font-medium text-[1rem]/[1.618rem] border border-green-light {{ request('jfsi') == 'Semua' || !request('jfsi') ? 'bg-green-light' : '' }} text-navy-night px-6 py-4 rounded-full">Semua</button>
                        </li>
                        @foreach ($types as $key => $type)
                            <li>
                                <button type="submit" name="jfsi" value="{{ $type }}"
                                    class="inline-block cursor-pointer font-medium text-[1rem]/[1.618rem] text-navy-night border border-green-light {{ request('jfsi') == $type ? 'bg-green-light' : '' }} px-6 py-4 rounded-full">{{ $type }}</button>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </div>
        </section>
        {{-- End Group News --}}

        {{-- News --}}
        <section>
            @php
                $indexShouldBeDisplayed = 2;
            @endphp
            @if ($informations->count() > 0)
                <div class="flex flex-col gap-y-10 lg:grid lg:grid-cols-4 lg:auto-rows-fr lg:gap-x-5">
                    @foreach ($informations as $key => $information)
                        @if ($key == $indexShouldBeDisplayed)
                            <a href="{{ route('berita-detail', $information->informasi_id) }}"
                                class="lg:row-span-2 lg:col-span-2">
                                <div class="relative h-72 lg:h-[46rem]">
                                    <img src="{{ 'storage/information_images/' . $information->thumbnail_url ?? '' }}"
                                        alt="" class="rounded-xl w-full h-full object-cover">
                                    <div
                                        class="absolute bottom-3 left-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                        <x-heroicon-o-calendar-days class="w-6 h-6" />
                                        <p class="text-[1rem]/[1.618rem]">
                                            {{ $information->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="py-3">
                                    <h1 class="font-bold text-[1.618rem]/[2.618rem]">
                                        {{ $information->judul_informasi }}
                                    </h1>
                                    <p class="text-[1rem]/[1.618rem]">
                                        {{ Str::substr($information->isi_informasi, 0, 200) }}
                                    </p>
                                </div>
                            </a>

                            @php
                                if ($key % 2 == 0) {
                                    $indexShouldBeDisplayed += 3;
                                } else {
                                    $indexShouldBeDisplayed += 7;
                                }
                            @endphp
                        @else
                            <a href="{{ route('berita-detail', $information->informasi_id) }}" class="lg:h-full">
                                <div class="relative h-72 lg:h-52">
                                    <img src="{{ 'storage/information_images/' . $information->thumbnail_url ?? '' }}"
                                        alt="" class="rounded-xl w-full h-full object-cover">
                                    <div
                                        class="absolute bottom-3 left-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                        <x-heroicon-o-calendar-days class="w-6 h-6" />
                                        <p class="text-[1rem]/[1.618rem]">
                                            {{ $information->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="py-3">
                                    <h1 class="font-bold text-[1.618rem]/[2.618rem]">
                                        {{ $information->judul_informasi }}
                                    </h1>
                                    <p class="text-[1rem]/[1.618rem]">
                                        {{ Str::substr($information->isi_informasi, 0, 200) }}
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-center text-navy-night text-[1rem]/[1.618rem] border border-green-light py-5 rounded-xl">
                    Data Tidak
                    Tersedia</p>
            @endif
        </section>

        {{-- Pagination --}}
        <section>
            <div class="mt-20">
                {{ $informations->links() }}
            </div>
        </section>
        {{-- End Pagination --}}
    </div>
</x-guest-layout>
