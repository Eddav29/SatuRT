<div
    class="notification-screen fixed left-1/2 -translate-x-1/2 flex justify-center h-fit w-fit overflow-hidden top-0 right-0 bottom-0 z-[999999] ">
    <div class="notification-container mt-5 relative space-y-2">
        {{-- <div class="notification flex items-center justify-start w-full max-w-[350px] md:max-w-[450px] z-50 py-1 px-6 bg-white rounded-full">
            <div class="h-10 flex items-center text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <p class="ml-3 truncate overflow-ellipsis text-gray-500 font-normal select-none">Data berhasil dihapus</p>
        </div> --}}
    </div>
</div>

@push('scripts')
    <script>
        const notificationContainer = document.querySelector('.notification-container');

        function pushNotification(type, message) {
            const notification = document.createElement('div');
            notification.classList.add('notification', 'flex', 'items-center', 'justify-start', 'w-full',
                'max-w-[1000px]', 'z-50', 'py-1', 'px-6', 'bg-white', 'rounded-full');

            let icon;
            switch (type) {
                case 'success':
                    icon =
                        `<div class="h-10 flex items-center text-green-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>`;
                    break;
                case 'error':
                    icon =
                        `<div class="h-10 flex items-center text-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>`;
                    break;
                case 'warning':
                    icon =
                        `<div class="h-10 flex items-center text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>`;
                    break;
            }
            notification.innerHTML = `
                ${icon}
                <p class="ml-3 truncate overflow-ellipsis text-gray-500 font-normal select-none">${message}</p>
            `;
            notificationContainer.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'remove-notification .5s linear forwards';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }

        @if (session()->has('message'))
            pushNotification('{{ session('message')['type'] }}', '{{ session('message')['message'] }}')
            {{ session()->forget('message') }}
        @endif
    </script>
@endpush
