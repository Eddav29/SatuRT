<x-guest-layout>
    <div class="flex flex-col gap-y-10 w-full max-w-7xl mx-auto">
        {{-- Start Hero Section --}}
        <section>
            <div class="flex flex-col gap-y-12 lg:gap-y-20 lg:pt-10">
                <div class="flex flex-col gap-y-3">
                    <h1 class="text-center font-semibold text-[1rem]/[1.618rem]">
                        Keberagaman Usaha Mikro di RT Ini
                    </h1>
                    <h1 class="font-bold text-[1.618rem]/[2.618rem] text-center lg:text-[2.618rem]/[3.618rem]">
                        Jelajahi UMKM di Lingkungan Anda: Bersama, Kita Tingkatkan Ekonomi Lokal
                    </h1>
                    <div class="flex justify-center items-center">
                        <a href="#" class="bg-green-light px-7 py-4 rounded-xl">
                            Mulai Jelajah
                        </a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('assets/images/OBJECTS.svg') }}" alt="" class="lg:w-full">
                </div>
            </div>
        </section>
        {{-- End Hero Section --}}

        {{-- Start Intro Section --}}
        <section>
            <div class="flex flex-col gap-y-10">
                <div class="flex flex-col gap-y-5">
                    <div class="border-b-4 border-green-light">
                        <h1 class="font-bold text-[1.618rem]/[2.618rem]">UMKM</h1>
                    </div>
                    <div class="lg:grid lg:grid-cols-2">
                        <p class="text-[1rem]/[1.618rem]">Selamat datang di pusat keberagaman UMKM yang dinamis, tempat
                            berkumpulnya usaha kecil dan
                            menengah yang penuh inovasi dan siap untuk memperkaya lingkungan kita. Bersiaplah untuk
                            mengeksplorasi dan mendukung berbagai usaha lokal yang menawarkan produk dan jasa unik,
                            dibuat dengan dedikasi dan kecintaan.</p>
                        <div class="grid grid-rows-1 grid-cols-2 gap-x-5 max-lg:hidden">
                            <img src="{{ asset('assets/images/gemma-stpjHJGqZyw-unsplash.webp') }}" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                            <img src="{{ asset('assets/images/alex-hudson-m3I92SgM3Mk-unsplash.webp') }}" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-3">
                        <div class="grid grid-rows-1 grid-cols-2 gap-x-3 lg:hidden">
                            <img src="{{ asset('assets/images/nrd-D6Tu_L3chLE-unsplash.webp') }}" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                            <img src="{{ asset('assets/images/gabriella-clare-marino-4cjzmwojr5M-unsplash.webp') }}" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/the-grand-cheese-master-TJDBqlvTdGI-unsplash.webp') }}" alt=""
                                class="rounded-xl w-full object-cover h-[15rem] lg:h-[30rem]">
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
        </section>
        {{-- End Intro Section --}}

        {{-- Start Group Section --}}
        <section>
            <div class="overflow-hidden">
                <form id="filterForm" action="{{ route('usaha') }}" class="w-full overflow-x-auto no-scrollbar">
                    <ul class="flex flex-nowrap w-max gap-4">
                        @if (request('jenis_umkm'))
                            <input type="hidden" name="jenis_umkm" value="{{ request('jenis_umkm') }}">
                        @endif
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <li>
                            <a href="{{ route('usaha') }}"
                                class="inline-block cursor-pointer font-medium border border-green-light text-navy-night px-6 py-4 rounded-full {{ request()->fullUrl() == route('usaha') ? 'bg-green-light' : '' }}">Semua</a>
                        </li>
                        @foreach ($types as $key => $type)
                            <li>
                                <button type="button" name="jenis_umkm" value="{{ $type }}"
                                    class="jenis-umkm-button inline-block cursor-pointer font-medium border border-green-light text-navy-night px-6 py-4 rounded-full {{ request('jenis_umkm') == $type ? 'bg-green-light' : '' }}">{{ $type }}</button>
                            </li>
                        @endforeach
                        @foreach ($statuses as $key => $status)
                            <li>
                                <button type="button" name="status" value="{{ $status }}"
                                    class="status-button inline-block cursor-pointer font-medium border border-green-light text-navy-night px-6 py-4 rounded-full {{ request('status') == $status ? 'bg-green-light' : '' }}">{{ $status }}</button>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </div>
        </section>
        {{-- End Group Section --}}

        {{-- Start Listing Section --}}
        <section>
            <div class="grid auto-rows-fr grid-cols-1">
                <ul id="umkm-list-container"
                    class="grid grid-cols-1 gap-y-10 auto-rows-[minmax(12rem,1fr)] lg:grid-cols-2 lg:gap-x-32 lg:gap-y-10">
                </ul>
            </div>
        </section>
        {{-- End Listing Section --}}

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
            const jenis_umkm_param = urlParams.get('jenis_umkm');
            const status_param = urlParams.get('status');
            const urlParamsObj = {};

            if (jenis_umkm_param) {
                urlParamsObj.jenis_umkm = jenis_umkm_param;
            }

            if (status_param) {
                urlParamsObj.status = status_param;
            }

            $('.jenis-umkm-button').click(function() {
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.delete('jenis_umkm');

                const jenisUmkmValue = $(this).val();

                currentUrl.searchParams.append('jenis_umkm', jenisUmkmValue);

                window.location.href = currentUrl;
            });

            $('.status-button').click(function() {
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.delete('status');

                const statusValue = $(this).val();

                currentUrl.searchParams.append('status', statusValue);

                window.location.href = currentUrl;
            });

            const queryString = $.param(urlParamsObj);
            let pages = 2;
            let current_page = 0;
            let bool = false;
            let lastPage = 0;
            let total_data = 0;

            firstLoad();

            $(window).scroll(function() {
                let height = $(document).height() - 800;

                if ($(window).scrollTop() + $(window).height() >= height && bool == false && lastPage > pages - 2) {
                    bool = true;
                    $('#loading').show();
                    loadData(pages)
                        .then(() => {
                            bool = false;
                            pages++;
                            if (pages - 2 == lastPage) {
                                $('#all-data-showed').show();
                            }
                        })
                }
            })


            function loadData(page) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: queryString ? `api/v1/usaha?page=${page}&${queryString}` :
                            `api/v1/usaha?page=${page}`,
                        type: 'GET',
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            let listUsaha = response.data.data;
                            $('#loading').hide();

                            // Append data
                            let html = '';

                            listUsaha.forEach((usaha, index) => {

                                html += card(usaha);

                            })

                            $('#umkm-list-container').append(html);

                            resolve();
                        }
                    })
                })
            }

            function firstLoad(indexToBigDisplay) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: queryString ? `api/v1/usaha?page=1&${queryString}` : `api/v1/usaha?page=1`,
                        type: 'GET',
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            lastPage = response.data.last_page;
                            let listUsaha = response.data.data;
                            if (response.data.total == 0) {
                                $('#all-data-showed').text(
                                    `Maaf yaaa data UMKM nya belum ada`);
                            } else {
                                $('#all-data-showed').text(
                                    `Semua UMKM sudah saya tampilkan yaaa....`);
                            }
                            $('#loading').hide();

                            // Append data
                            let html = '';

                            listUsaha.forEach((usaha, index) => {

                                html += card(usaha);

                            })

                            $('#umkm-list-container').append(html);
                            resolve();
                        }
                    })
                })
            }


            const card = (umkm) => {
                return `
                <li>
                            <a href="usaha/${umkm.umkm_id}"
                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-x-3 group">
                                <div>
                                    <img src="${!umkm.thumbnail_url.startsWith('http') ? 'storage/images_storage/' + umkm.thumbnail_url : umkm.thumbnail_url}" alt=""
                                        class="w-full h-[20rem] object-cover rounded-xl aspect-[2/3]">
                                </div>
                                <div class="flex flex-col gap-y-2 md:col-span-2 lg:col-span-1">
                                    <div>
                                        <h1 class="font-bold text-[1.618rem]/[2.618rem] group-hover:underline">
                                            ${strLimit(umkm.nama_umkm, 50, '...')}</h1>
                                    </div>
                                    <div aria-label="MSMS-Type" class="px-3 py-2 bg-green-light text-navy-night rounded-md text-base w-fit">${umkm.jenis_umkm}</div>
                                    <div>
                                        <h1 class="font-medium text-[1rem]/[1.618rem]">Deskripsi:</h1>
                                        <p class="text-[1rem]/[1.618rem]">${strLimit(umkm.keterangan, 100, '...')}</p>
                                    </div>
                                </div>
                            </a>
                        </li>
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
                return string.length <= limit ? string : (string.substring(0, limit) + ending)
            }
        </script>
    @endpush
</x-guest-layout>
