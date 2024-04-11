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
                                    <h1 class="text-xl font-bold text-navy-night/80">
                                        {{ $information->judul_informasi }}
                                    </h1>
                                    <p class="text-xs/6">Klik Untuk Detail</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
                fetch(`/api/pengumuman/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('announcement-modal').innerHTML = announcementModal(data);
                    })
            }

            function fetchFinanceReport(id) {
                fetch(`/api/laporan-keuangan/${id}`)
                    .then(res => res.json())
                    .then(data => {
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
                    <div class="flex flex-col mt-2 overflow-auto no-scrollbar">
                        <h1 class="text-2xl/7 font-bold">${data.data.title}</h1>
                        <div class="flex flex-col w-max text-sm/7 mt-2">
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-medium w-32">Dibuat Pada:</h6>
                                <h6>:</h6>
                                <h6>${data.data.created_at}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-medium w-32">Terakhir Diperbarui:</h6>
                                <h6>:</h6>
                                <h6>${data.data.created_at === data.data.updated_at ? '-' : data.data.updated_at}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-medium w-32">Asal</h6>
                                <h6>:</h6>
                                <h6>${data.data.finance_origin}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-medium w-32">Jenis</h6>
                                <h6>:</h6>
                                <h6>${data.data.finance_type}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-medium w-32">Nominal</h6>
                                <h6>:</h6>
                                <h6>${data.data.amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center">
                                <h6 class="font-medium w-32">Saldo Sebelumnya</h6>
                                <h6>:</h6>
                                <h6>${data.data.balance_before.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h6>
                            </div>
                            <div class="flex gap-x-5 items-center ">
                                <h6 class="font-medium w-32">Saldo Saat Ini</h6>
                                <h6>:</h6>
                                <h6>${data.data.balance_now.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h6>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h1 class="font-medium text-sm/7 ">Keterangan</h1>
                            <div>
                                <p class="text-sm/5">${data.data.description}</p>
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
                    <div class="flex flex-col gap-y-2 mt-2 overflow-y-auto no-scrollbar">
                        <h1 class="text-2xl/7 font-bold">${data.data.title}</h1>
                        <div class="flex flex-col gap-y-2 md:grid md:grid-cols-2 md:grid-rows-1">
                            <div class="text-sm/5">
                                <h6 class="font-medium">Dibuat oleh: </h6>
                                <h5>${data.data.created_by}</h5>
                            </div>
                            <div class="text-sm/5">
                                <h6 class="font-medium">Dibuat pada: </h6>
                                <h5>${data.data.created_at}</h5>
                            </div>
                        </div>
                        <div class="text-sm/5">
                            <div>
                                <h1 class="font-medium">Isi Pengumuman</h1>
                                <div>
                                    <p class="text-sm/5">${data.data.description}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            }
        </script>
    @endpush
</x-app-layout>
