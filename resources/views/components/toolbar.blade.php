@props(['toolbar_id', 'active', 'toolbar_route' => []])

@if (!empty($toolbar_route))
    <div id="modal-container" x-data="{ isOpen: false }">
        <div class="p-2 bg-white grid grid-cols-3 md:grid-flow-col md:grid-cols-{{count($toolbar_route) > 1 ? '2' : '1' }} w-full md:w-fit rounded-md">
            @isset($toolbar_route['detail'])
                <a href="{{ $toolbar_route['detail'] }}"
                    class="select-none rounded-md inline-flex justify-center items-center py-3 px-4 md:w-32 @if ($active == 'detail') bg-[#2563EB1A] @endif text-[#2563EB]"
                    draggable="false"><x-heroicon-o-eye class="w-6 h-6" /> <span class="md:ml-4 ml-2">Detail</span></a>
            @endisset
            @isset($toolbar_route['edit'])
                <a href="{{ $toolbar_route['edit'] }}"
                    class="select-none rounded-md inline-flex justify-center items-center py-3 px-4 md:w-32 @if ($active == 'edit') bg-[#22C55E1A] @endif text-[#22C55E]"
                    draggable="false"><x-heroicon-o-pencil class="w-6 h-6" /> <span class="md:ml-4 ml-2">Edit</span></a>
            @endisset
            @isset($toolbar_route['hapus'])
                <button
                    class="select-none rounded-md inline-flex justify-center items-center py-3 px-4 md:w-32 @if ($active == 'hapus') bg-[#EF44441A] @endif text-[#EF4444]"
                    draggable="false" @click.prevent="isOpen = true"><x-heroicon-o-trash class="w-6 h-6" /> <span
                        class="md:ml-4 ml-2">Hapus</span></button>
            @endisset
        </div>

    <div class="modal-screen fixed w-full top-0 right-0 bottom-0 left-0 z-[99999] bg-black bg-opacity-35 " x-cloak
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
                                class="bg-blue-500 text-white px-4 py-2 rounded-md md:text-md text-sm" id="deleteButton"
                                onclick="hapusData('{{ $toolbar_id }}')">Ya</button>
                            <button type="submit" @click.prevent="isOpen = false"
                                class="bg-white text-black border border-gray-300 px-4 py-2 rounded-md md:text-md text-sm">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
    <script>
        @isset($toolbar_route['hapus'])
            function hapusData(id) {
                fetch(`{{ $toolbar_route['hapus'] }}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        if (data.code >= 200) {
                            if (data && data.code >= 200 && data.code < 300) {
                                pushNotification('success', data.message);
                                if (data?.redirect) {
                                    setTimeout(() => {
                                        window.location.href = data.redirect;
                                    }, 1000);
                                }
                            } else {
                                pushNotification('error', data.message || 'An error occurred');
                            }
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        pushNotification('error', error);
                    });
            }
        @endisset
    </script>
@endpush
