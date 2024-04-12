<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="['Home', 'Laporan Warga']" :url="['home', 'pelaporan']" />
    </x-slot>

    <section x-data="{ open: false }">
        <div
            class="overflow-x-auto bg-white-snow px-5 py-7 text-navy-night rounded-xl gap-y-5 flex flex-col h-[35rem] mt-5 mx-3">

            <table id="example" class="table-auto min-w-full">
                <thead class="bg-blue-gray border-black">
                    <tr>
                        <th class="px-4 py-2">Pelapor</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Jenis Laporan</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td class="px-4 py-2">Eddo Dava</td>
                        <td class="px-4 py-2">Menunggu</td>
                        <td class="px-4 py-2 ">
                            <span class="bg-green-300 px-2 py-1 rounded-lg">Public</span>
                        </td>
                        <td class="px-4 py-2">19 Februari 2024</td>
                        <td class="px-4 py-2">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Detail
                            </button>
                        </td>
                    </tr>
                    <!-- Tambahkan baris-baris lainnya di sini -->
                </tbody>
            </table>


        </div>

        <x-scripts.chartjs></x-scripts.chartjs>
        @push('scripts')
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#example').DataTable({
                        "searching": true, // Aktifkan fitur pencarian
                        "ordering": true, // Aktifkan fitur penyortiran
                        "paging": true // Aktifkan fitur halaman
                    });
                });
            </script>
        @endpush
    </section>
</x-app-layout>
