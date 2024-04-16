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
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/penduduk_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Total Penduduk</h1>
                        <h1 class="text-base/7 font-semibold">{{ $residentCount }} Penduduk</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/dokumen_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Permintaan Dokumen</h1>
                        <h1 class="text-base/7 font-semibold">{{ $documentRequestCount }} Permintaan</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/keluarga_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Total Kartu Keluarga</h1>
                        <h1 class="text-base/7 font-semibold">{{ $familyCardCount }} Kartu Keluarga</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-white-snow rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
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
            <div class="flex flex-col 2xl:grid 2xl:grid-cols-6 2xl:grid-rows-1 mt-5 lg:gap-x-5 max-2xl:gap-y-5">
                {{-- Report Start --}}
                <div
                    class="relative lg:col-span-4 row-span-2 2xl:order-last 2xl:col-span-2 flex flex-col  bg-white-snow px-5 py-6 overflow-hidden max-h-[40rem] rounded-xl">
                    <div class="flex items-center gap-x-5">
                        <div class="flex justify-center items-center p-3 lg:p-2 w-12 h-12 bg-blue-gray rounded-full">
                            <x-heroicon-o-eye class="w-12 h-12" />
                        </div>
                        <div>
                            <h1 class="text-xl/7 font-bold text-navy-night">Laporan Warga</h1>
                        </div>
                    </div>
                    <div class="gap-y-3 h-full mt-5 overflow-auto">
                        <div class="flex flex-col gap-y-4">
                            @if ($listOfResidentReport->count() > 0)
                                @foreach ($listOfResidentReport as $report)
                                    <div @click.stop="open = !open; fetchResidentReport('{{ $report->pelaporan_id }}')"
                                        class="flex gap-x-5 cursor-pointer bg-slate-100 w-full p-5 rounded-md">
                                        <div>
                                            <h1 class="text-xs/7 ">
                                                {{ \Carbon\Carbon::parse($report->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                                            </h1>
                                            <div class="mt-2">
                                                <h1 class="text-xs ">
                                                    {{ $report->pengajuan->penduduk->nama }}
                                                </h1>
                                                <h1 class="text-lg font-semibold text-navy-night/80">
                                                    {{ $report->jenis_pelaporan }}</h1>
                                                <p class="text-xs/5">Klik Untuk Detail</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-5 bg-slate-100 rounded-md">
                                    <p class="text-center">Tidak ada laporan minggu ini</p>
                                </div>
                            @endif
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
            <div x-show="open" id="resident-report-modal"
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
                        <h1 class="text-xl font-bold">Pengumuman</h1>
                    </div>
                </div>
                <div class="flex cursor-pointer flex-col gap-y-4 overflow-auto">
                    @if ($informations->count() > 0)
                        @foreach ($informations as $information)
                            <div @click.stop="open = !open; fetchAnnouncement('{{ $information->informasi_id }}')"
                                id="{{ $information->informasi_id }}"
                                class="announcement flex gap-x-5 cursor-pointer bg-slate-100 w-full p-5 rounded-md">
                                <div>
                                    <h1 class="text-xs/7 ">
                                        {{ \Carbon\Carbon::parse($information->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                                    </h1>
                                    <h1 class="text-lg/7 font-semibold text-navy-night/80">
                                        {{ $information->judul_informasi }}</h1>
                                    <p class="text-xs/5">Klik Untuk Detail</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-5 bg-slate-100 rounded-md">
                            <p class="text-center">Tidak ada laporan yang belum disetujui</p>
                        </div>
                    @endif
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
            document.addEventListener("DOMContentLoaded", function() {
                const monthlyFinanceReport = @json($financeReport);
                const minValue = Math.min(Math.min(...Object.values(monthlyFinanceReport.incomes)), Math.min(...Object
                    .values(
                        monthlyFinanceReport.expenses)));
                const maxValue = Math.max(Math.max(...Object.values(monthlyFinanceReport.incomes)), Math.max(...Object
                    .values(
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


                const announcement = document.querySelectorAll('.announcement');


            });

            function fetchResidentReport(id) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(`/api/pelaporan/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                        document.getElementById('resident-report-modal').innerHTML = residentReportModal(data);
                    });
            }


            function fetchAnnouncement(id) {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(`/api/pengumuman/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                        document.getElementById('announcement-modal').innerHTML = announcementModal(data.data.title,
                            data.data.created_by, data.data.created_at, data.data.description);
                    });
            }

            const residentReportModal = (data) => {
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
                            <div>
                                <h1 class="font-medium">Lampiran</h1>
                                <div x-data="{ openImage: false }">
                                    <img @click="openImage = !openImage"
                                        src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}"
                                        alt="" class="rounded-xl max-h-[30rem] w-full object-cover"
                                        draggable="false">
                                    <div x-show="openImage"
                                        class="absolute top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                        <img @click="openImage = false" x-show="openImage"
                                            @click.outside="openImage = false"
                                            src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}"
                                            alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                            draggable="false">
                                        <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer"
                                            @click="openImage = false">
                                            <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                        </div>
                                    </div>
                                </div>
                            </div>
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

            const announcementModal = (title, created_by, created_at, content) => {
                return `
            <div
                    class="bg-white-snow w-full sm:max-w-3xl h-[80%] 2xl:max-w-7xl lg:h-[95%] overflow-hidden rounded-xl p-8 flex flex-col gap-y-5">
                    <div class="flex justify-between items-center">
                        <h1 class="text-lg font-bold">Informasi</h1>
                        <button @click.stop="open = !open">
                            <x-heroicon-o-x-mark class="w-8 h-8" />
                        </button>
                    </div>
                    <div class="flex flex-col gap-y-2 mt-2 overflow-y-auto no-scrollbar">
                        <h1 class="text-2xl/7 font-bold">${title}</h1>
                        <div class="flex flex-col gap-y-2 md:grid md:grid-cols-2 md:grid-rows-1">
                            <div class="text-sm/5">
                                <h6 class="font-medium">Dibuat oleh: </h6>
                                <h5>${created_by}</h5>
                            </div>
                            <div class="text-sm/5">
                                <h6 class="font-medium">Dibuat pada: </h6>
                                <h5>${created_at}</h5>
                            </div>
                        </div>
                        <div class="text-sm/5">
                            <div>
                                <h1 class="font-medium">Isi Pengumuman</h1>
                                <div>
                                    <p class="text-sm/5">
                                        ${content}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            }
        </script>
    @endpush
</x-app-layout>
