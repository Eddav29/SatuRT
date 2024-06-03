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
                    <div class="flex justify-between items-center">
                        <input type="text" name="search" id="searchFieldMobile" placeholder="Cari Berita"
                            class="w-full py-5 rounded-lg outline-none ring-0 border-0 focus:ring-1 focus:ring-green-light">
                        <button type="submit">
                            <x-heroicon-o-magnifying-glass class="w-8 h-8 absolute bg-white top-1/2 right-3 -translate-y-1/2" />
                        </button>
                    </div>
                </form>
            </div>
        </section>
        {{-- End Search Section --}}

        @if ($newInformation)
            {{-- New News --}}
            <section>
                <a href="{{ route('berita-detail', $newInformation->informasi_id) }}" class="group">
                    <div class="relative h-72 lg:h-[85vh]">
                        <img src="{{ strpos($newInformation->thumbnail_url, 'http') === 0 ? $newInformation->thumbnail_url : asset('storage/images_storage/' . $newInformation->thumbnail_url) }}"
                            alt="" class="rounded-xl w-full h-full object-cover">
                        <div
                            class="absolute top-3 right-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-green-light/70 backdrop-blur-3xl flex gap-3">
                            <p class="text-[1rem]/[1.618rem]">
                                Informasi Baru
                            </p>
                        </div>
                        <div
                            class="absolute bottom-3 text-navy-night left-3 z-10 text-[1.618rem]/[2.618rem]">
                            @php
                                $judul = Str::limit($newInformation->judul_informasi, 50, '...');
                            @endphp

                            <div
                                class="left-3 lg:bottom-20 max-w-fit rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                <x-heroicon-o-calendar-days class="w-6 h-6" />
                                <p class="text-[1rem]/[1.618rem]">
                                    {{ $newInformation->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <h1
                                class="group-hover:underline text-md lg:text-[2.618rem]/[3.618rem] group-hover:text-navy-night duration-300 font-semibold">
                                {{ $judul }}</h1>
                        </div>
                    </div>
                </a>
            </section>
            {{-- End New News --}}
        @endif

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
                            @if ($type !== 'Pengumuman')
                                <li>
                                    <button type="submit" name="jfsi" value="{{ $type }}"
                                        class="inline-block cursor-pointer font-medium text-[1rem]/[1.618rem] text-navy-night border border-green-light {{ request('jfsi') == $type ? 'bg-green-light' : '' }} px-6 py-4 rounded-full">{{ $type }}</button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </form>
            </div>
        </section>
        {{-- End Group News --}}

        {{-- News --}}
        <section>
            <div id="news-container" class="flex flex-col gap-y-10 lg:grid lg:grid-cols-4 lg:auto-rows-fr lg:gap-x-5">
            </div>
        </section>
        {{-- End News --}}

        <section>
            <div class="mt-20">
                <div id="loading" style="display: none" role="status">
                    <div class="flex items-center justify-center gap-x-5">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <h1 class="text-center">Tunggu sebentar yaaa....</h1>
                    </div>
                </div>
                <h1 id="all-data-showed" class="text-center" style="display: none"></h1>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            const jfsiParam = urlParams.get('jfsi');
            const searchParam = urlParams.get('search');
            const urlParamsObj = {};


            if (jfsiParam) {
                urlParamsObj.jfsi = jfsiParam;
            }

            if (searchParam) {
                urlParamsObj.search = searchParam;
            }

            const queryString = $.param(urlParamsObj);
            let indexToBigDisplay = 0;
            let pages = 2;
            let current_page = 0;
            let bool = false;
            let lastPage = 0;
            let total_data = 0;

            firstLoad(indexToBigDisplay);

            $(window).scroll(function() {
                let height = $(document).height() - 800;

                if ($(window).scrollTop() + $(window).height() >= height && bool == false && lastPage > pages - 2) {
                    bool = true;
                    $('#loading').show();
                    loadData(pages, indexToBigDisplay)
                        .then(() => {
                            bool = false;
                            pages++;
                            if (pages - 2 == lastPage) {
                                $('#all-data-showed').show();
                            }
                        })
                }
            })


            function loadData(page, indexToBigDisplay) {
                indexToBigDisplay = 2;
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: queryString ? `api/v1/berita?page=${page}&${queryString}` :
                            `api/v1/berita?page=${page}`,
                        type: 'GET',
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            let listInformasi = response.data.data;
                            $('#loading').hide();

                            // Append data
                            let html = '';

                            listInformasi.forEach((informasi, index) => {
                                if (index === indexToBigDisplay) {

                                    html += bigCard(informasi);

                                    if (index % 2 == 0) {
                                        indexToBigDisplay += 3;
                                    } else {
                                        indexToBigDisplay += 7;
                                    }
                                } else {
                                    html += smallCard(informasi);
                                }
                            })
                            $('#news-container').append(html);
                            resolve();
                        }
                    })
                })
            }

            function firstLoad(indexToBigDisplay) {
                indexToBigDisplay = 2;
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: queryString ? `api/v1/berita?page=1&${queryString}` : `api/v1/berita?page=1`,
                        type: 'GET',
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            lastPage = response.data.last_page;
                            let listInformasi = response.data.data;
                            if (response.data.total == 0) {
                                $('#all-data-showed').text(
                                    `Maaf yaaa belum ada informasi dengan kategori yang anda cari`);
                            } else {
                                $('#all-data-showed').text(
                                    `Semua informasinya sudah saya tampilkan yaaa....`);
                            }
                            $('#loading').hide();

                            // Append data
                            let html = '';

                            listInformasi.forEach((informasi, index) => {

                                if (index === indexToBigDisplay) {

                                    html += bigCard(informasi);

                                    if (index % 2 == 0) {
                                        indexToBigDisplay += 3;
                                    } else {
                                        indexToBigDisplay += 7;
                                    }
                                } else {
                                    html += smallCard(informasi);
                                }
                            })
                            $('#news-container').append(html);
                            resolve();
                        }
                    })
                })
            }

            const bigCard = (informasi) => {
                return `
                <a href="berita/${informasi.informasi_id}"
                                    class="lg:row-span-2 lg:col-span-2 group">
                                    <div class="relative h-72 lg:h-[46rem]">
                                        <img src="${urlCheck(informasi.thumbnail_url) ? informasi.thumbnail_url : asset('storage/images_storage/' + informasi.thumbnail_url)}" loading="lazy"
                                            alt="" class="rounded-xl w-full h-full object-cover">
                                        <div
                                            class="absolute bottom-3 left-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                            <x-heroicon-o-calendar-days class="w-6 h-6" />
                                            <p class="text-[1rem]/[1.618rem]">
                                                ${formatDate(informasi.created_at)}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="py-3">
                                        <h1 class="font-bold text-[1.618rem]/[2.618rem] group-hover:underline">
                                            ${informasi.judul_informasi}
                                        </h1>
                                        <p class="text-[1rem]/[1.618rem] break-words">
                                            ${informasi.excerpt}...
                                        </p>
                                    </div>
                                </a>
                `;
            }

            window.assetBaseUrl = "{{ asset('storage/images_storage') }}";

            const smallCard = (informasi) => {
                return `
                <a href="berita/${informasi.informasi_id}"
                                    class="lg:h-[30.5rem] group">
                                    <div class="relative h-72 lg:h-52">
                                        <img src="${urlCheck(informasi.thumbnail_url) ? informasi.thumbnail_url : `${window.assetBaseUrl}/${informasi.thumbnail_url}`}" loading="lazy"
                                            alt="" class="rounded-xl w-full h-full object-cover">
                                        <div
                                            class="absolute bottom-3 left-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                            <x-heroicon-o-calendar-days class="w-6 h-6" />
                                            <p class="text-[1rem]/[1.618rem]">
                                                ${formatDate(informasi.created_at)}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="py-3">
                                        <h1 class="font-bold text-[1.618rem]/[2.618rem] group-hover:underline">
                                            ${strLimit(informasi.judul_informasi, 50, '...')}
                                        </h1>
                                        <p class="text-[1rem]/[1.618rem] break-words">
                                            ${strLimit(informasi.excerpt, 100, '...')}
                                        </p>
                                    </div>
                                </a>
                `;
            }

            const urlCheck = (url) => {
                return url.includes('http');
            }

            const formatDate = (date) => {
                return new Date(date).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }

            const strLimit = (string, limit, ending = '...') => {
                return string <= limit ? string : string.substring(0, limit) + ending
            }
        </script>
    @endpush
</x-guest-layout>
