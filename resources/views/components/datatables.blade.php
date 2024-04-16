@props([
    'url',
    'primaryKey' => 'kartu_keluarga_id',
    'columns',
    'pageLength' => 10,
    'aksi' => [
        'detail' => true,
        'edit' => true,
        'hapus' => true,
    ],
    'hasFilter' => false,
    'filter' => [
        [
            'label' => 'sdf',
            'key' => 'chel',
            'columnIndex' => null,
        ],
    ],
])

<x-styles.datatables />

<div class="overflow-hidden">
    <div class=" overflow-auto">
        <table id="example" class="min-w-[75rem] overflow-auto">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th class="bg-blue-gray">{{ $column['label'] }}</th>
                    @endforeach
                    @if ($aksi['detail'] || $aksi['edit'] || $aksi['hapus'])
                        <th class="bg-blue-gray">Aksi</th>
                    @endif
                </tr>
            </thead>
        </table>
    </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script>
        function hapus(id) {
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                fetch(`{{ $url }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        alert('Data berhasil dihapus');
                        $('#example').DataTable().ajax.reload();
                    } else {
                        alert('Data gagal dihapus');
                    }
                });
            }
        }
        $(document).ready(
            function() {
                let pageLengthValue = {{ $pageLength }};
                $('#example').DataTable({
                    pageLength: pageLengthValue,
                    ajax: {
                        url: '/api/v1/{{ $url }}-list',
                        type: 'GET',
                        dataSrc: 'data'
                    },
                    columns: [
                        @foreach ($columns as $column)
                            {
                                data: '{{ $column['key'] }}'
                            },
                        @endforeach {
                            data: null,
                            render: function(data, type, row) {
                                let aksi = '';
                                @if ($aksi['detail'])
                                    aksi +=
                                        `<a href="{{ $url }}/${row.{{ $primaryKey }}}" class="text-black inline-flex items-center"><x-heroicon-o-eye class="w-5 h-4" /> Detail</a> `;
                                @endif
                                @if ($aksi['edit'])
                                    aksi +=
                                        `<a href="{{ $url }}/${row.{{ $primaryKey }}}/edit" class="text-green-500 ml-3 inline-flex items-center"><x-heroicon-o-pencil class="w-5 h-4" /> Edit</a> `;
                                @endif
                                @if ($aksi['hapus'])
                                    aksi +=
                                        `<button class="text-red-500 ml-3 inline-flex items-center" onclick="hapus('${row.{{ $primaryKey }}}')"><x-heroicon-o-trash class="w-5 h-4" /> Hapus</button>`;
                                @endif
                                return aksi;
                            }
                        }
                    ],
                    layout: {
                        top2Start: function() {
                            let toolbar = document.createElement('div');
                            toolbar.classList.add('w-fit');
                            toolbar.innerHTML = `
                                <button class="inline-flex w-full items-center bg-blue-500 text-white p-4 rounded-lg" type="button">
                                    <x-heroicon-o-plus class="w-6 h-6"/> <span class="ml-2">Tambah Data</span>
                                </button>
                            `;
                            toolbar.addEventListener('click', function() {
                                window.location.href = '{{ $url }}/create';
                            });
                            return toolbar;
                        },
                        top2End: function() {
                            let search = document.createElement('div');
                            search.classList.add('w-full', 'my-3');
                            search.innerHTML = `
                            <div class="relative items-center border border-gray-300 rounded-lg">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                                    </div>
                                <input type="text" class="px-12 py-4 placeholder:text-gray-300 border-none bg-transparent w-full focus:ring-0" placeholder="Search...">
                            </div>
                            `;
                            search.querySelector('input').addEventListener('input', function() {
                                $('#example').DataTable().search(this.value).draw();
                            });
                            return search;
                        },
                        topStart: '',
                        topEnd: function() {
                            let toolbar = document.createElement('div');
                            toolbar.classList.add('dropdown');
                            toolbar.innerHTML = `
                                <button class="inline-flex bg-white border px-6 py-2 rounded-xl" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <x-heroicon-o-adjustments-vertical class="w-6 h-6"/> <span class="ml-2">Filters</span>
                                </button>
                                <div class="hidden absolute right-0 top-[120%] bg-white border border-gray-300 rounded-xl z-10" aria-labelledby="dropdownMenuButton">
                                    @foreach ($filter as $item)
                                        <button class="block px-4 py-2 w-full text-left hover:text-white hover:bg-blue-500
                                        @if (count($filter) > 1) @if ($loop->first)
                                                rounded-t-xl
                                            @elseif ($loop->last)
                                                rounded-b-xl @endif
                                        @else
                                            rounded-xl
                                        @endif
                                        "
                                                x-dt-filter-label="{{ $item['key'] }}" x-dt-filter-column="{{ $item['columnIndex'] }}">
                                            {{ $item['label'] }}
                                        </button>
                                    @endforeach

                                </div>
                            `;
                            toolbar.style.display = 'inline-flex';
                            toolbar.style.position = 'relative';
                            toolbar.addEventListener('click', function(event) {
                                let dropdownMenu = this.querySelector('button').nextElementSibling;
                                dropdownMenu.classList.toggle('hidden');
                            });
                            if ('{{ $hasFilter }}') {
                                return toolbar;
                            }
                            return '';
                        },
                        bottomStart: 'info',
                    }
                });

                $('div button[x-dt-filter-label]').on('click', function() {
                    const filterValue = $(this).attr('x-dt-filter-label');
                    const filterColumn = $(this).attr('x-dt-filter-column');

                    console.log('Filter value:', filterValue);
                    console.log('Filter column:', filterColumn);
                    filterData(filterValue, filterColumn);
                });

                function filterData(value, column = null) {
                    let table = $('#example').DataTable();

                    if (column) {
                        table.column(column).search(value).draw();
                    } else {
                        table.search(value).draw();
                    }
                }
                const paginateElelement = $('section .paging_full_numbers').addClass(
                    'bg-white border border-gray-200 w-fit flex rounded-lg');
            });
    </script>
@endpush
