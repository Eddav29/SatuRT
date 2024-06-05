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
                        <h1 class="text-sm/5">Pemasukan RT Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</h1>
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
                        <h1 class="text-sm/5">Pengeluaran RT Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                        </h1>
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
                    <div x-data="{ tahun: '{{ date('Y') }}' }"
                        class="overflow-hidden bg-white-snow px-5 py-7 rounded-xl gap-y-5 flex flex-col h-fit xl:h-full">
                        <div class="grid grid-cols-1 grid-rows-2 gap-y-5 md:grid-rows-1 md:grid-cols-3">
                            <div class="flex items-center gap-x-5 md:col-span-2">
                                <div
                                    class="flex justify-center items-center p-3 lg:p-2 w-12 h-12 bg-blue-gray rounded-full">
                                    <x-heroicon-o-currency-dollar class="w-12 h-12" />
                                </div>
                                <div>
                                    <h1 class="text-xl/7 font-bold" x-text="'Grafik Keuangan Tahun ' + tahun"></h1>
                                </div>
                            </div>
                            <div class="mt-3 md:justify-self-end md:px-2">
                                <select id="year" @change="tahun = $event.target.value"
                                    class="bg-blue-gray/40 rounded-md border-gray-200 w-full md:w-fit">
                                    @foreach ($fiveYearsAgo as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                    <option value="5 Tahun Terakhir">5 Tahun Terakhir</option>
                                </select>
                            </div>
                        </div>
                        <div class="relative h-[40rem] overflow-x-auto no-scrollbar">
                            <div id="loading-chart"
                                class="absolute top-0 left-0 flex justify-center items-center backdrop-blur-sm w-full h-full rounded-xl">
                                <div role="status">
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
                            </div>
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
                class="overflow-hidden bg-white-snow px-5 py-7 text-navy-night rounded-xl gap-y-5 flex flex-col h-[35rem] mt-5 2xl:mt-0">
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
                            @if ($information instanceof \App\Models\Informasi)
                                <div @click.stop="open = !open; fetchAnnouncement('{{ $information->informasi_id }}', 'Pengumuman')"
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
                            @endif
                            @if ($information instanceof \App\Models\Pelaporan)
                                <div @click.stop="open = !open; fetchAnnouncement('{{ $information->pelaporan_id }}', 'Pelaporan')"
                                    class="flex gap-x-5 cursor-pointer bg-slate-100 w-full p-5 rounded-md">
                                    <div>
                                        <h6 class="text-xs/3 font-medium">
                                            {{ \Carbon\Carbon::parse($information->pengajuan->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                                        </h6>
                                        <div class="mt-2">
                                            <h6 class="text-xs font-medium">
                                                {{ $information->pengajuan->penduduk->nama }}</h6>
                                            <h1 class="text-xl font-bold text-navy-night/80 ">
                                                {{ $information->pengajuan->keperluan }}
                                            </h1>
                                            <p class="text-xs/6">Klik Untuk Detail</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
            document.addEventListener("DOMContentLoaded", async function() {
                const yearFilter = document.getElementById('year');

                yearFilter.value = new Date().getFullYear();

                let monthlyFinanceReport = await fetchFinanceReportChartData(yearFilter.value);
                document.getElementById('loading-chart').classList.add('hidden');
                let minValue = Math.min(...Object.values(monthlyFinanceReport.incomes), ...Object.values(
                    monthlyFinanceReport.expenses));
                let maxValue = Math.max(...Object.values(monthlyFinanceReport.incomes), ...Object.values(
                    monthlyFinanceReport.expenses));


                const ctx = document.getElementById('myChart');

                let labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

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


                const announcement = document.querySelectorAll('.announcement');

                yearFilter.addEventListener('change', async (event) => {
                    monthlyFinanceReport = await fetchFinanceReportChartData(event.target.value);

                    let updatedLabels = [];

                    if (event.target.value === '5 Tahun Terakhir') {
                        updatedLabels = Object.keys(monthlyFinanceReport.incomes);
                    } else {
                        updatedLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                            'Oct', 'Nov', 'Dec'
                        ];
                    }

                    minValue = Math.min(...Object.values(monthlyFinanceReport.incomes), ...Object
                        .values(
                            monthlyFinanceReport.expenses));
                    maxValue = Math.max(...Object.values(monthlyFinanceReport.incomes), ...Object
                        .values(
                            monthlyFinanceReport.expenses));

                    financialSummary.data.datasets[0].data = Object.values(monthlyFinanceReport
                        .incomes);
                    financialSummary.data.datasets[1].data = Object.values(monthlyFinanceReport
                        .expenses);

                    financialSummary.options.scales.y.ticks.min = minValue <= 100000 ? minValue :
                        minValue -
                        1000000;
                    financialSummary.options.scales.y.ticks.max = maxValue >= 1000000 ? maxValue :
                        maxValue + 1000000;

                    financialSummary.data.labels = updatedLabels;
                    financialSummary.update();
                });
            });

            async function fetchFinanceReportChartData(year) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                const response = await fetch(`/api/v1/keuangan/${year}`);
                const data = await response.json();
                document.getElementById('loading').classList.replace('flex', 'hidden')
                return data.data;
            }

            function fetchAnnouncement(id, type) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(type === 'Pengumuman' ? `/api/v1/pengumuman/${id}` : `/api/v1/pelaporan/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                        document.getElementById('announcement-modal').innerHTML = type === 'Pengumuman' ? announcementModal(
                            data) : residentReportModal(data);
                    })
            }

            function fetchFinanceReport(id) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(`/api/v1/laporan-keuangan/${id}`)
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
                                <h6>${data.data.financial_origin}</h6>
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
                let fileName = data.data.file ? displayFileName(data.data.file) : 'Tidak ada lampiran';
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
                                    ${data.data.file === null ? '' : `
                                                            <h1 class="font-semibold">Lampiran</h1>
                                                            ${data.data.file_type === 'file' ? `
                                                                                                                                                                                    <div class="flex gap-x-2 items-center">
                                                                                                                                                                                        <div id="file-icon">
                                                                                                                                                                                            ${generateIcon(data.data.file_extension)}
                                                                                                                                                                                        </div>
                                                                                                                                                                                        ${data.data.file_extension === 'pdf' ? `
                                                                <div class="flex flex-col" id="preview-file-container">
                                                                    <a id="preview-file" href="file/pengumuman/${data.data.id}" class="text-blue-500 py-3 text-sm font-light">${fileName}</a>
                                                                </div>` 
                                                                                                                                                                        : `
                                                                <div class="flex flex-col" id="preview-file-container">
                                                                    <a id="preview-file" href="file/pengumuman/${data.data.id}/download" class="text-blue-500 py-3 text-sm font-light" target="_blank">${fileName}</a>
                                                                </div>`}
                                                                                                                                                                        </div>` : 
                                                                `
                                                                                                                                                                                    <div x-data="{ openImage: false }">
                                                                                                                                                                                        <img @click="openImage = !openImage" src="storage/announcement/${data.data.file}" alt="" class="rounded-xl max-h-[30rem] w-full object-cover" draggable="false">
                                                                                                                                                                                        <div x-show="openImage" class="absolute top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                                                                                                                                                                            <img @click="openImage = false" x-show="openImage" @click.outside="openImage = false" src="storage/announcement/${data.data.file}" alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full" draggable="false">
                                                                                                                                                                                            <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer" @click="openImage = false">
                                                                                                                                                                                                <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                        `} `}
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

            const residentReportModal = (data) => {
                if (data.data.attachment) {
                    const image_url = data.data.attachment.includes('http') || data.data.attachment.includes('https') ? data
                        .data
                        .attachment : `storage/images_storage/${data.data.attachment}`
                }
                return `
                <div
                    class="bg-white-snow w-full sm:max-w-3xl 2xl:max-w-7xl text-navy-night h-[80%] lg:h-[95%] overflow-hidden rounded-xl p-8 flex flex-col gap-y-5">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-bold">Laporan Warga</h1>
                        <button @click="open = !open">
                            <x-heroicon-o-x-mark class="w-8 h-8" />
                        </button>
                    </div>
                    <div class="flex flex-col mt-2 gap-y-2 overflow-auto no-scrollbar">
                        <h1 class="text-2xl/7 font-bold">${data.data.jenis_laporan}</h1>
                        <div class="flex flex-col gap-y-2 md:grid md:grid-cols-2 md:grid-rows-1">
                            <div class="text-sm/5">
                                <h6 class="font-medium">Pelapor: </h6>
                                <h5>${data.data.created_by}</h5>
                            </div>
                            <div class="text-sm/5">
                                <h6 class="font-medium">Dibuat pada: </h6>
                                <h5>${data.data.created_at}</h5>
                            </div>
                            <div class="text-sm/5">
                                <h6 class="font-medium">Status Pengajuan: </h6>
                                <h5 class="w-fit py-2 px-3 rounded-lg ${data.data.status === 'Menunggu Persetujuan' ? 'bg-yellow-200 text-yellow-950' : data.data.status === 'Diterima' ? 'bg-green-200 text-green-950' : data.data.status === 'Ditolak' ? 'bg-red-200 text-red-950' : data.data.status === 'Dibatalkan' ? 'bg-red-200 text-red-950' : ''}">${data.data.status}</h5>
                            </div>
                        </div>
                        <div class="text-sm/5">
                            ${data.data.attachment === null ? '' : `
                                    <div>
                                        <h1 class="font-medium">Lampiran</h1>
                                        <div x-data="{ openImage: false }">
                                            <img @click="openImage = !openImage"
                                                src="${image_url}"
                                                alt="" class="rounded-xl w-full object-cover"
                                                draggable="false">
                                            <div x-show="openImage"
                                                class="absolute top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                                <img @click="openImage = false" x-show="openImage"
                                                    @click.outside="openImage = false"
                                                    src="${image_url}"
                                                    alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                                    draggable="false">
                                                <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer"
                                                    @click="openImage = false">
                                                    <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `}
                        </div>
                        <div class="mt-2">
                            <h1 class="font-medium text-sm/7 ">Keperluan</h1>
                            <div>
                                <p class="text-sm/5">
                                    ${data.data.purposes}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                `

            }

            const generateIcon = (file_extension) => {
                if (file_extension == 'pdf') {
                    return pdfIcon();
                } else if (file_extension == 'doc' || file_extension == 'docx') {
                    return docsIcon();
                } else if (file_extension == 'xls' || file_extension == 'xlsx') {
                    return sheetIcon();
                }
            }

            const pdfIcon = () => {
                return `
                <svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                        <path style="fill:#E2E5E7;"
                            d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z" />
                        <path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z" />
                        <polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 " />
                        <path style="fill:#F15642;"
                            d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16 V416z" />
                        <g>
                            <path style="fill:#FFFFFF;"
                                d="M101.744,303.152c0-4.224,3.328-8.832,8.688-8.832h29.552c16.64,0,31.616,11.136,31.616,32.48 c0,20.224-14.976,31.488-31.616,31.488h-21.36v16.896c0,5.632-3.584,8.816-8.192,8.816c-4.224,0-8.688-3.184-8.688-8.816V303.152z M118.624,310.432v31.872h21.36c8.576,0,15.36-7.568,15.36-15.504c0-8.944-6.784-16.368-15.36-16.368H118.624z" />
                            <path style="fill:#FFFFFF;"
                                d="M196.656,384c-4.224,0-8.832-2.304-8.832-7.92v-72.672c0-4.592,4.608-7.936,8.832-7.936h29.296 c58.464,0,57.184,88.528,1.152,88.528H196.656z M204.72,311.088V368.4h21.232c34.544,0,36.08-57.312,0-57.312H204.72z" />
                            <path style="fill:#FFFFFF;"
                                d="M303.872,312.112v20.336h32.624c4.608,0,9.216,4.608,9.216,9.072c0,4.224-4.608,7.68-9.216,7.68 h-32.624v26.864c0,4.48-3.184,7.92-7.664,7.92c-5.632,0-9.072-3.44-9.072-7.92v-72.672c0-4.592,3.456-7.936,9.072-7.936h44.912 c5.632,0,8.96,3.344,8.96,7.936c0,4.096-3.328,8.704-8.96,8.704h-37.248V312.112z" />
                        </g>
                        <path style="fill:#CAD1D8;"
                            d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z" />
                    </svg>
                `
            }

            const docsIcon = () => {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48">
                    <linearGradient id="pg10I3OeSC0NOv22QZ6aWa_v0YYnU84T2c4_gr1" x1="-209.942" x2="-179.36" y1="-3.055" y2="27.526" gradientTransform="translate(208.979 6.006)" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#55adfd"></stop><stop offset="1" stop-color="#438ffd"></stop>
                    </linearGradient>
                    <path fill="url(#pg10I3OeSC0NOv22QZ6aWa_v0YYnU84T2c4_gr1)" d="M39.001,13.999v27c0,1.105-0.896,2-2,2h-26	c-1.105,0-2-0.895-2-2v-34c0-1.104,0.895-2,2-2h19l2,7L39.001,13.999z"></path>
                    <path fill="#fff" fill-rule="evenodd" d="M15.999,18.001v2.999	h17.002v-2.999H15.999z" clip-rule="evenodd"></path>
                    <path fill="#fff" fill-rule="evenodd" d="M16.001,24.001v2.999	h17.002v-2.999H16.001z" clip-rule="evenodd"></path><path fill="#fff" fill-rule="evenodd" d="M15.999,30.001v2.999	h12.001v-2.999H15.999z" clip-rule="evenodd"></path>
                    <linearGradient id="pg10I3OeSC0NOv22QZ6aWb_v0YYnU84T2c4_gr2" x1="-197.862" x2="-203.384" y1="-4.632" y2=".89" gradientTransform="translate(234.385 12.109)" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#427fdb"></stop><stop offset="1" stop-color="#0c52bb"></stop>
                    </linearGradient>
                    <path fill="url(#pg10I3OeSC0NOv22QZ6aWb_v0YYnU84T2c4_gr2)" d="M30.001,13.999l0.001-9l8.999,8.999L30.001,13.999z"></path>
                </svg>
                `;
            }

            const sheetIcon = () => {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48">
                    <path fill="#43a047" d="M37,45H11c-1.657,0-3-1.343-3-3V6c0-1.657,1.343-3,3-3h19l10,10v29C40,43.657,38.657,45,37,45z"></path>
                    <path fill="#c8e6c9" d="M40 13L30 13 30 3z"></path><path fill="#2e7d32" d="M30 13L40 23 40 13z"></path>
                    <path fill="#e8f5e9" d="M31,23H17h-2v2v2v2v2v2v2v2h18v-2v-2v-2v-2v-2v-2v-2H31z M17,25h4v2h-4V25z M17,29h4v2h-4V29z M17,33h4v2h-4V33z M31,35h-8v-2h8V35z M31,31h-8v-2h8V31z M31,27h-8v-2h8V27z"></path>
                </svg>`;
            };

            function displayFileName(storedFileName) {
                let pos = storedFileName.indexOf('-');
                if (pos !== -1) {
                    return storedFileName.substring(pos + 1);
                }
                return storedFileName;
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
