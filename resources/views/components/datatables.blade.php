@props([
    'id' => '{{ $id }}',
    'url',
    'columns',
    'pageLength' => 10,
    'aksi' => [
        'detail' => false,
        'edit' => false,
        'hapus' => false,
    ],
    'filter' => [
        [
            'label' => '',
            'key' => '',
            'columnIndex' => null,
        ],
    ],
    'top2Start' => 'Tambah Data',
    'layoutTop2Start' => true,
    'layoutTop2End' => true,
    'layoutTopEnd' => false,
])


<x-styles.datatables />

<div x-data="{ isOpen: false }">
    <div class="overflow-hidden">
        <div class="overflow-auto">
            <table id="{{ $id }}" class="display max-md:min-w-[75rem] w-max overflow-auto" width="100%">
                <thead class="bg-blue-gray w-max">
                    <tr>
                        @foreach ($columns as $column)
                            <th>{{ $column['label'] }}</th>
                        @endforeach
                        @if ($aksi['detail'] || $aksi['edit'] || $aksi['hapus'])
                            <th class="w-full flex justify-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal-screen fixed w-full top-0 right-0 bottom-0 left-0 z-[9999] bg-black bg-opacity-35 " x-cloak
        x-show="isOpen">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[350px] md:max-w-[450px] z-50 py-10 px-12 bg-white rounded-xl">
            <div class="modal">
                <div class="modal-content space-y-4">
                    <div class="modal-header">
                        <h2 class="font-bold md:text-xl text-md">Hapus Data</h2>
                    </div>
                    <div class="modal-body">
                        <p class="md:text-md text-sm">Apakah Anda yakin ingin menghapus data ini?</p>
                        <div class="flex justify-end mt-8 space-x-4">
                            <button type="submit" @click.prevent="isOpen = false"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md md:text-md text-sm"
                                id="deleteButton_{{ $id }}" onclick="hapusTable_{{ $id }}()"
                                data-id="">Ya</button>
                            <button type="submit" @click.prevent="isOpen = false"
                                class="bg-white text-black border border-gray-300 px-4 py-2 rounded-md md:text-md text-sm"
                                onclick="setHapusId_{{ $id }}('{{ $id }}')">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script>
        window['setHapusId_{{ $id }}'] = function(id) {
            deleteButton.dataset.id = id;
        }

        window['hapusTable_{{ $id }}'] = function() {
            const id = deleteButton.dataset.id;
            fetch(`{{ $url }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    if (data.code >= 200) {
                        if (data && data.code >= 200 && data.code < 303) {
                            pushNotification('success', data.message);
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            }
                            $('#{{ $id }}').DataTable().ajax.reload();
                        } else {
                            pushNotification('error', data.message || 'An error occurred');
                        }
                    }
                })
                .catch(error => {
                    pushNotification('error', 'Kesalahan terjadi, silahkan coba lagi');
                });
        }


        const deleteButton = document.getElementById('deleteButton_{{ $id }}');
        $(document).ready(
            function() {
                let pageLengthValue = {{ $pageLength }};
                $('#{{ $id }}').DataTable({
                    pageLength: pageLengthValue,
                    ajax: {
                        url: '/api/v1{{ $url }}',
                        type: 'GET',
                        datatype: 'json',
                        dataSrc: 'data',
                    },
                    columns: [
                        @foreach ($columns as $column)
                            {
                                data: '{{ $column['key'] }}',
                                @if (isset($column['className']))
                                    className: '{{ $column['className'] }}',
                                @endif
                                render: function(data, type, row) {
                                    @if (isset($column['style']) || isset($column['customStyle']))
                                        let style = '';
                                        @if (isset($column['style']))
                                            style +=
                                                '{{ $column['style'] }}';
                                        @endif

                                        @if (isset($column['customStyle']))
                                            @foreach ($column['customStyle'] as $key => $value)
                                                if (data == '{{ $key }}') {
                                                    style += ' {{ $value }}';
                                                }
                                            @endforeach
                                        @endif
                                        return `<div class="${style}">${data ?? ''}</div>`;
                                    @else
                                        return data;
                                    @endif
                                }

                            },
                        @endforeach {
                            data: null,
                            orderable: false,
                            render: function(data, type, row) {
                                let id = {!! json_encode($id) !!}
                                @if (!empty($aksi))
                                    let aksi =
                                        '<div class="flex justify-start space-x-2">'; // Open a flex container

                                    @if ($aksi['detail'])
                                        aksi +=
                                            `<a href="{{ $url }}/${row[id]}" class="text-black inline-flex items-center"><x-heroicon-o-eye class="w-5 h-4" /> <span class="ml-2">Detail</span></a> `;
                                    @endif
                                    @if ($aksi['edit'])
                                        aksi +=
                                            `<a href="{{ $url }}/${row[id]}/edit" class="text-green-500 inline-flex items-center"><x-heroicon-o-pencil class="w-5 h-4" /> <span class="ml-2">Edit</span></a> `;
                                    @endif
                                    @if ($aksi['hapus'])
                                        aksi +=
                                            `<button class="text-red-500 inline-flex items-center" onclick="setHapusId_{{ $id }}('${row[id]}')" @click.prevent="isOpen = true"><x-heroicon-o-trash class="w-5 h-4" /> <span class="ml-2">Hapus</span></button>`;
                                    @endif

                                    aksi += '</div>'; // Close the flex container

                                    return aksi;
                                @endif
                            }
                        }
                    ],
                    order: [],
                    layout: {
                        @if ($layoutTop2Start)
                            top2Start: function() {
                                let toolbar = document.createElement('div');
                                toolbar.classList.add('w-fit');
                                toolbar.innerHTML = `
                                <button class="inline-flex w-full items-center bg-blue-500 text-white p-4 rounded-lg" type="button">
                                    <x-heroicon-o-plus class="w-6 h-6"/> <span class="ml-2">{{ $top2Start }}</span>
                                </button>
                            `;
                                toolbar.addEventListener('click', function() {
                                    window.location.href = '{{ $url }}/create';
                                });
                                return toolbar;
                            },
                        @else
                            top2Start: function() {
                                let toolbar = document.createElement('div');
                                toolbar.classList.add('w-fit');
                                return toolbar;
                            },
                        @endif

                        @if ($layoutTop2End)
                            top2End: function() {
                                let search = document.createElement('div');
                                search.classList.add('w-full', 'my-3', );
                                search.innerHTML = `
                            <div class="relative items-center border border-gray-300 rounded-lg">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                                    </div>
                                <input type="text" class="px-12 py-4 placeholder:text-gray-300 border-none bg-transparent w-full focus:ring-0" placeholder="Search...">
                            </div>
                            `;
                                search.querySelector('input').addEventListener('input', function() {
                                    $('#{{ $id }}').DataTable().search(this.value)
                                        .draw();
                                });
                                return search;
                            },
                        @elseif (!$layoutTop2End && $layoutTopEnd)
                            top2End: function() {
                                    let toolbar = document.createElement('div');
                                    toolbar.classList.add('dropdown', 'mb-6');
                                    toolbar.innerHTML = `
                                    <button class="inline-flex bg-tranparent border px-6 py-4 rounded-lg gap-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <x-heroicon-o-adjustments-vertical class="w-6 h-6"/> <span class="ml-2">Filters</span>
                                </button>
                                <div class="hidden absolute right-0 min-w-[17rem] w-max max-h-[20rem] overflow-y-auto top-[120%] bg-white-snow border z-10 rounded-lg overflow-hidden p-2" aria-labelledby="dropdownMenuButton">
                                    <button class="flex gap-3 justify-start items-center text-red-500 p-4 w-full text-left hover:text-navy-night hover:bg-blue-gray rounded" x-dt-filter-label="" x-dt-filter-column=""><x-heroicon-o-arrow-path class="w-5 h-5"/>Reset</button>
                                    @foreach ($filter as $item)
                                    <div class="border-b">
                                        <div class="flex justify-start p-2 font-semibold uppercase text-gray-400">
                                            <h1>{{ $item['title'] }}</h1>    
                                            </div>
                                            @foreach ($item['data'] as $data)
                                                <button class="block p-4 w-full text-left hover:text-navy-night hover:bg-blue-gray rounded" x-dt-filter-label="{{ $data['key'] }}" x-dt-filter-column="{{ $data['columnIndex'] }}">{{ $data['label'] }}</button>
                                            @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            `;
                                    toolbar.style.display = 'inline-flex';
                                    toolbar.style.position = 'relative';
                                    toolbar.addEventListener('click', function(event) {
                                        let dropdownMenu = this.querySelector('button')
                                            .nextElementSibling;
                                        dropdownMenu.classList.toggle('hidden');
                                    });
                                    if ('{{ $layoutTopEnd }}') {
                                        return toolbar;
                                    }
                                    return '';
                                },
                        @endif
                        topStart: '',

                        @if ($layoutTopEnd && $layoutTop2Start && $layoutTop2End)
                            topEnd: function() {
                                let toolbar = document.createElement('div');
                                toolbar.classList.add('dropdown', 'mb-6');
                                toolbar.innerHTML = `
                                <button class="inline-flex bg-tranparent border px-6 py-4 rounded-lg gap-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <x-heroicon-o-adjustments-vertical class="w-6 h-6"/> <span class="ml-2">Filters</span>
                                </button>
                                <div class="hidden absolute right-0 min-w-[17rem] w-max max-h-[20rem] overflow-y-auto top-[120%] bg-white-snow border z-10 rounded-lg overflow-hidden p-2" aria-labelledby="dropdownMenuButton">
                                    <button class="flex gap-3 justify-start items-center text-red-500 p-4 w-full text-left hover:text-navy-night hover:bg-blue-gray rounded" x-dt-filter-label="" x-dt-filter-column=""><x-heroicon-o-arrow-path class="w-5 h-5"/>Reset</button>
                                    @foreach ($filter as $item)
                                    <div class="border-b">
                                        <div class="flex justify-start p-2 font-semibold uppercase text-gray-400">
                                            <h1>{{ $item['title'] }}</h1>    
                                            </div>
                                            @foreach ($item['data'] as $data)
                                                <button class="block p-4 w-full text-left hover:text-navy-night hover:bg-blue-gray rounded" x-dt-filter-label="{{ $data['key'] }}" x-dt-filter-column="{{ $data['columnIndex'] }}">{{ $data['label'] }}</button>
                                            @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            `;
                                toolbar.style.display = 'inline-flex';
                                toolbar.style.position = 'relative';
                                toolbar.addEventListener('click', function(event) {
                                    let dropdownMenu = this.querySelector('button')
                                        .nextElementSibling;
                                    dropdownMenu.classList.toggle('hidden');
                                });
                                if ('{{ $layoutTopEnd }}') {
                                    return toolbar;
                                }
                                return '';
                            },
                        @elseif ($layoutTop2End && $layoutTopEnd)
                            topEnd: function() {
                                    let toolbar = document.createElement('div');
                                    toolbar.classList.add('dropdown', 'mb-6');
                                    toolbar.innerHTML = `
                                    <button class="inline-flex bg-tranparent border px-6 py-4 rounded-lg gap-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <x-heroicon-o-adjustments-vertical class="w-6 h-6"/> <span class="ml-2">Filters</span>
                                </button>
                                <div class="hidden absolute right-0 min-w-[17rem] w-max max-h-[20rem] overflow-y-auto top-[120%] bg-white-snow border z-10 rounded-lg overflow-hidden p-2" aria-labelledby="dropdownMenuButton">
                                    <button class="flex gap-3 justify-start items-center text-red-500 p-4 w-full text-left hover:text-navy-night hover:bg-blue-gray rounded" x-dt-filter-label="" x-dt-filter-column=""><x-heroicon-o-arrow-path class="w-5 h-5"/>Reset</button>
                                    @foreach ($filter as $item)
                                    <div class="border-b">
                                        <div class="flex justify-start p-2 font-semibold uppercase text-gray-400">
                                            <h1>{{ $item['title'] }}</h1>    
                                            </div>
                                            @foreach ($item['data'] as $data)
                                                <button class="block p-4 w-full text-left hover:text-navy-night hover:bg-blue-gray rounded" x-dt-filter-label="{{ $data['key'] }}" x-dt-filter-column="{{ $data['columnIndex'] }}">{{ $data['label'] }}</button>
                                            @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            `;
                                    toolbar.style.display = 'inline-flex';
                                    toolbar.style.position = 'relative';
                                    toolbar.addEventListener('click', function(event) {
                                        let dropdownMenu = this.querySelector('button')
                                            .nextElementSibling;
                                        dropdownMenu.classList.toggle('hidden');
                                    });
                                    if ('{{ $layoutTopEnd }}') {
                                        return toolbar;
                                    }
                                    return '';
                                },
                        @else
                            topEnd: '',
                        @endif
                        bottomStart: 'info',
                        bottomEnd: 'paging'

                    }
                });

                $('div button[x-dt-filter-label]').on('click', function() {
                    const filterValue = $(this).attr('x-dt-filter-label');
                    const filterColumn = $(this).attr('x-dt-filter-column');
                    filterData_{{ $id }}(filterValue, filterColumn);
                });

                window['filterData_{{ $id }}'] = function(value = null, column = null) {
                    let table = $('#{{ $id }}').DataTable();

                    if (column !== null && column !== "" && value !== null && value !== "") {
                        table.column(column).search(value).draw();
                    } else if (column !== null && column !== "" && (value === null || value === "")) {
                        table.column(column).search('').draw();
                    } else {
                        table.columns().search('').draw();
                        table.search('').draw();
                    }
                }

                let rows = document.querySelectorAll('div .dt-layout-row');

                rows.forEach(function(row) {
                    let start = row.querySelector('.dt-start');
                    let end = row.querySelector('.dt-end');

                    if (!start || !start.innerHTML.trim()) {
                        row.style.justifyContent = 'flex-end';
                    } else {
                        row.style.justifyContent = 'space-between';
                    }
                });

                setInterval(function() {
                    let table = $('#{{ $id }}').DataTable();
                    table.ajax.reload(null, false);
            }, 5000);
            });
    </script>
@endpush
