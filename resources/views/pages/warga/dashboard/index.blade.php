<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="['Home', 'Dashboard']" :url="['home', 'dashboard']" />
    </x-slot>
    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        {{-- Card  --}}
        <section>
            <div
                class="grid grid-cols-1 grid-rows-4 md:grid-rows-2 md:grid-cols-2 2xl:grid-cols-4 2xl:grid-rows-1 gap-5">
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl text-navy-night">
                    <div>
                        <div class="bg-blue-gray rounded-full p-3 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/penduduk_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Total Anggota Keluarga</h1>
                        <h1 class="text-base/7 font-semibold">{{ $familyMemberCount }} Anggota</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-3 w-12 h-12 flex justify-center items-center">
                            <x-heroicon-o-arrow-trending-up />
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">
                            Pemasukan RT Bulan
                            April</h1>
                        <h1 class="text-base/7 font-semibold">Rp. {{ number_format($incomeThisMonth) }}</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-3 w-12 h-12 flex justify-center items-center">
                            <x-heroicon-o-arrow-trending-down />
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">
                            Pengeluaran RT Bulan
                            April</h1>
                        <h1 class="text-base/7 font-semibold">Rp. {{ number_format($expenseThisMonth) }}</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-3 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/keuangan_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">
                            Saldo RT</h1>
                        <h1 class="text-base/7 font-semibold">Rp. {{ number_format($balance) }}</h1>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Card --}}

        {{-- Report and Chart --}}
        <section x-data="{ open: false }">
            <div class="flex flex-col 2xl:grid 2xl:grid-cols-6 2xl:grid-rows-1 mt-5 lg:gap-x-5 gap-y-5">
                {{-- Report Start --}}
                <div
                    class="relative lg:col-span-4 row-span-2 2xl:order-last 2xl:col-span-2 flex flex-col  bg-white-snow px-5 py-6 overflow-hidden max-h-[40rem] rounded-xl">
                    <div class="flex items-center gap-x-5">
                        <div class="flex justify-center items-center p-3 lg:p-2 w-12 h-12 bg-blue-gray rounded-full">
                            <x-heroicon-o-eye class="w-12 h-12" />
                        </div>
                        <div>
                            <h1 class="text-xl/7 font-bold text-navy-night">Transparansi Keuangan</h1>
                        </div>
                    </div>
                    <div class="gap-y-3 h-full mt-5 overflow-auto">
                        @if (count($detailFinance) > 0)
                            <div class="flex flex-col gap-y-4">
                                @foreach ($detailFinance as $detail)
                                    <div @click.stop="open = !open; fetchFinanceReport('{{ $detail->detail_keuangan_id }}')"
                                        class="flex gap-x-5 cursor-pointer bg-slate-100 w-full p-5 rounded-md">
                                        <div>
                                            <h1 class="text-xs/7 ">
                                                {{ \Carbon\Carbon::parse($detail->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                                            </h1>
                                            <h1 class="text-lg/7 font-semibold text-navy-night/80">
                                                {{ $detail->jenis_keuangan }} -
                                                {{ $detail->judul }}</h1>
                                            <p class="text-xs/5">Klik Untuk Detail</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="w-full h-full flex justify-center items-center">
                                <h1 class="text-center">
                                    Tidak Ada Data</h1>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Report End --}}

                {{-- Chart Start --}}
                <div class="2xl:col-span-4 xl:h-[40rem] text-navy-night">
                    <div
                        class="overflow-hidden bg-white-snow px-5 py-7 rounded-xl gap-y-5 flex flex-col h-fit xl:h-full">
                        <div class="flex items-center gap-x-5">
                            <div
                                class="flex justify-center items-center p-3 lg:p-2 w-12 h-12 bg-blue-gray rounded-full">
                                <x-heroicon-o-currency-dollar class="w-12 h-12" />
                            </div>
                            <div>
                                <h1 class="text-xl/7 font-bold">Grafik Keuangan Tahun 2024</h1>
                            </div>
                        </div>
                        <div class="h-[40rem] overflow-x-auto no-scrollbar">
                            <div class="w-max sm:w-full h-full">
                                <canvas class="xl:h-full w-[50rem] sm:w-full" id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart End --}}
            </div>

            {{-- Modal --}}
            <div x-show="open" id="finance-report-modal"
                class="fixed w-screen flex items-center z-[9999999] justify-center bg-navy-night/50 h-screen top-0 left-0 px-6 py-7">

            </div>
            {{-- End Modal --}}
        </section>
        {{-- End Report and Chart --}}

        {{-- Announcement --}}
        <section x-data="{ open: false }">
            <div
                class="overflow-hidden bg-white-snow px-5 py-7 text-navy-night rounded-xl gap-y-5 flex flex-col h-[35rem] mt-5">
                <div class="flex items-center gap-x-5">
                    <div class="flex justify-center items-center p-3 w-12 h-12 lg:p-2 bg-blue-gray rounded-full">
                        <x-heroicon-o-information-circle class="w-12 h-12" />
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Pusat Informasi</h1>
                    </div>
                </div>
                @if (count($informations) > 0)
                    <div class="flex cursor-pointer flex-col gap-y-4 overflow-auto">
                        @foreach ($informations as $information)
                            <div @click.stop="open = !open; fetchAnnouncement('{{ $information->informasi_id }}')"
                                class="flex gap-x-5 cursor-pointer bg-slate-100 w-full p-5 rounded-md">
                                <div>
                                    <h6 class="text-xs/3 font-medium">
                                        {{ \Carbon\Carbon::parse($information->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                                    </h6>
                                    <div class="mt-2">
                                        <h6 class="text-xs font-medium">{{ $information->penduduk->nama }}</h6>
                                        <h1 class="text-xl font-bold text-navy-night/80 ">
                                            {{ $information->judul_informasi }}
                                        </h1>
                                        <p class="text-xs/6">Klik Untuk Detail</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 rounded-md w-full h-full flex justify-center items-center">
                        <p class="text-center">Belum ada informasi</p>
                    </div>
                @endif
            </div>

            {{-- Modal --}}
            <div x-show="open" id="announcement-modal"
                class="fixed w-screen flex items-center z-[9999999] justify-center bg-navy-night/50 h-screen top-0 left-0 px-6 py-7">

            </div>
            {{-- End Modal --}}
        </section>
        {{-- End Announcement --}}
    </div>

    <x-scripts.chartjs></x-scripts.chartjs>
    @push('scripts')
        <script>
            const monthlyFinanceReport = @json($financeReportMonthly);
            const minValue = Math.min(Math.min(...Object.values(monthlyFinanceReport.incomes)), Math.min(...Object.values(
                monthlyFinanceReport.expenses)));
            const maxValue = Math.max(Math.max(...Object.values(monthlyFinanceReport.incomes)), Math.max(...Object.values(
                monthlyFinanceReport.expenses)));

            const ctx = document.getElementById('myChart');

            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            let financialSummary = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pendapatan',
                            data: Object.values(monthlyFinanceReport.incomes),
                            borderWidth: 5,
                            fill: false,
                            pointRadius: 10,
                            pointBorderColor: 'rgba(13, 110, 253, 0.5)',
                            pointBackgroundColor: 'rgba(13, 110, 253, 0.5)',
                            borderColor: 'rgba(13, 110, 253, 0.2)',
                        },
                        {
                            label: "Pengeluaran",
                            data: Object.values(monthlyFinanceReport.expenses),
                            borderWidth: 5,
                            fill: false,
                            pointRadius: 10,
                            pointBorderColor: 'rgba(220, 53, 69, 0.5)',
                            pointBackgroundColor: 'rgba(220, 53, 69, 0.5)',
                            borderColor: 'rgba(220, 53, 69, 0.3)',
                        }
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    tension: 0.2,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                min: minValue <= 100000 ? minValue : minValue - 1000000,
                                max: maxValue >= 1000000 ? maxValue : maxValue + 1000000,
                                stepSize: 5,
                                callback: function(value, index, values) {
                                    let formatedValue = value.toLocaleString('id-ID', {
                                        'style': 'currency',
                                        'currency': 'IDR'
                                    });
                                    return formatedValue.substring(0, 7) + ' jt';
                                }
                            },
                        },
                    },
                },
            });

            function fetchAnnouncement(id) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(`/api/pengumuman/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                        document.getElementById('announcement-modal').innerHTML = announcementModal(data);
                    })
            }

            function fetchFinanceReport(id) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(`/api/laporan-keuangan/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                        document.getElementById('finance-report-modal').innerHTML = financeReportModal(data);
                    })
            }

            const financeReportModal = (data) => {
                return `
                <div
                    class="bg-white-snow w-full sm:max-w-3xl 2xl:max-w-7xl text-navy-night h-[80%] lg:h-[95%] overflow-hidden rounded-xl p-8 flex flex-col gap-y-5">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-bold">Laporan Keuangan</h1>
                        <button @click="open = !open">
                            <x-heroicon-o-x-mark class="w-8 h-8" />
                        </button>
                    </div>
                    <div class="flex flex-col mt-2 overflow-auto">
                        <h1 class="text-2xl/7 font-bold  ">${data.data.title}</h1>
                        <div class="flex flex-col w-max text-sm/7 mt-2">
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-semibold w-32">Dibuat Pada:</h6>
                                <h6>:</h6>
                                <h6>${data.data.created_at}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-semibold w-32">Terakhir Diperbarui:</h6>
                                <h6>:</h6>
                                <h6>${data.data.created_at === data.data.updated_at ? '-' : data.data.updated_at}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-semibold w-32">Asal</h6>
                                <h6>:</h6>
                                <h6>${data.data.finance_origin}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-semibold w-32">Jenis</h6>
                                <h6>:</h6>
                                <h6>${data.data.finance_type}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-semibold w-32">Nominal</h6>
                                <h6>:</h6>
                                <h6>${data.data.amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-semibold w-32">Saldo Sebelumnya</h6>
                                <h6>:</h6>
                                <h6>${data.data.balance_before.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center ">
                                <h6 class="font-semibold w-32">Saldo Saat Ini</h6>
                                <h6>:</h6>
                                <h6>${data.data.balance_now.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h6>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h1 class="font-semibold text-sm/7 ">Keterangan</h1>
                            <div class="content">
                                ${data.data.description}
                            </div>
                        </div>
                    </div>
                </div>
                `
            }

            const announcementModal = (data) => {
                return `<div
                    class="bg-white-snow w-full sm:max-w-3xl h-[80%] 2xl:max-w-7xl lg:h-[95%] overflow-hidden rounded-xl p-8 flex flex-col gap-y-5">
                    <div class="flex justify-between items-center">
                        <h1 class="text-lg font-bold">Informasi</h1>
                        <button @click.stop="open = !open">
                            <x-heroicon-o-x-mark class="w-8 h-8" />
                        </button>
                    </div>
                    <div class="flex flex-col gap-y-5 mt-2 overflow-y-auto">
                        <h1 class="text-2xl/7 font-bold ">${data.data.title}</h1>
                        <div class="flex flex-col gap-y-2 md:grid md:grid-cols-2 md:grid-rows-1">
                            <div class="text-sm/5">
                                <h6 class="font-semibold">Dibuat oleh: </h6>
                                <h5>${data.data.created_by}</h5>
                            </div>
                            <div class="text-sm/5">
                                ${data.data.updated_at === data.data.created_at ? '<h6 class="font-semibold">Dibuat pada: </h6>' : `<h6 class="font-semibold">Terakhir diperbarui: </h6>`}
                                        <h5>${data.data.updated_at}</h5>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="font-semibold">Lampiran</h1>
                                    ${data.data.file_extension && data.data.file_extension === 'pdf' ? `
                                    <div class="flex gap-x-2 items-center">
                                        <svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                            <path style="fill:#E2E5E7;" d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z" />
                                            <path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z" />
                                            <polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 " />
                                            <path style="fill:#F15642;"
                                            d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16 V416z" />
                                            <g>
                                                <path style="fill:#FFFFFF;" d="M101.744,303.152c0-4.224,3.328-8.832,8.688-8.832h29.552c16.64,0,31.616,11.136,31.616,32.48 c0,20.224-14.976,31.488-31.616,31.488h-21.36v16.896c0,5.632-3.584,8.816-8.192,8.816c-4.224,0-8.688-3.184-8.688-8.816V303.152z M118.624,310.432v31.872h21.36c8.576,0,15.36-7.568,15.36-15.504c0-8.944-6.784-16.368-15.36-16.368H118.624z" />
                                                <path style="fill:#FFFFFF;" d="M196.656,384c-4.224,0-8.832-2.304-8.832-7.92v-72.672c0-4.592,4.608-7.936,8.832-7.936h29.296 c58.464,0,57.184,88.528,1.152,88.528H196.656z M204.72,311.088V368.4h21.232c34.544,0,36.08-57.312,0-57.312H204.72z" />
                                                <path style="fill:#FFFFFF;"d="M303.872,312.112v20.336h32.624c4.608,0,9.216,4.608,9.216,9.072c0,4.224-4.608,7.68-9.216,7.68 h-32.624v26.864c0,4.48-3.184,7.92-7.664,7.92c-5.632,0-9.072-3.44-9.072-7.92v-72.672c0-4.592,3.456-7.936,9.072-7.936h44.912 c5.632,0,8.96,3.344,8.96,7.936c0,4.096-3.328,8.704-8.96,8.704h-37.248V312.112z" />
                                            </g>
                                            <path style="fill:#CAD1D8;"d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z" />
                                        </svg>
                                        <div class="flex flex-col" id="preview-file-container">
                                            <a id="preview-file" href="/file-download/${data.data.file}" class="text-blue-500 py-3 text-sm font-light" target="_blank">${data.data.file}</a>
                                        </div>
                                    </div>` : `
                                    <div x-data="{ openImage: false }">
                                        <img @click="openImage = !openImage" src="storage/information_images/${data.data.file}" alt="" class="rounded-xl max-h-[30rem] w-full object-cover" draggable="false">
                                        <div x-show="openImage" class="absolute top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                            <img @click="openImage = false" x-show="openImage" @click.outside="openImage = false" src="storage/information_images/${data.data.file}" alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full" draggable="false">
                                            <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer" @click="openImage = false">
                                                <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                            </div>
                                        </div>
                                    </div>`}
                                </div>
                                <div class="text-sm/5">
                                    <div>
                                        <h1 class="font-semibold">Isi Pengumuman</h1>
                                        <div class="content">
                                            ${data.data.description}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`
            }
        </script>
    @endpush
    @push('styles')
        <style>
            .content h2 {
                display: block;
                font-size: 1.5em;
                font-weight: bold;
            }

            .content h3 {
                display: block;
                font-size: 1.33em;
                font-weight: bold;
            }

            .content h4 {
                display: block;
                font-size: 1.17em;
                font-weight: bold;
            }

            .content ol {
                display: block;
                list-style-type: decimal;
                padding-left: 40px;
            }

            .content ul {
                display: block;
                list-style-type: disc;
                padding-left: 40px;
            }

            .content a {
                color: rgb(59 130 246);
                text-decoration: underline;
                background-color: transparent;
            }

            .content blockquote {
                padding: 1rem;
                margin: 1rem 0;
                border-left: 4px solid rgb(209 213 219);
            }

            .content table {
                table-layout: auto;
                width: 100%;
                font-size: 0.875rem;
                line-height: 1.25rem;
                text-align: left;
                color: #0B1215;
            }

            .content table th {
                background-color: rgb(229 231 235);
                padding: 0.75rem;
                border: 1px solid rgb(209 213 219);
            }

            .content table td {
                border: 1px solid rgb(209 213 219);
                padding: 0.75rem;
            }

            .content blockquote p {
                font-size: 1rem;
                line-height: 1.25rem;
                font-style: italic;
                font-weight: 500;
                line-height: 1.625;
                color: #0B1215;
            }
        </style>
    @endpush
</x-app-layout>
