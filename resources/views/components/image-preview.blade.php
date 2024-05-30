@props(['file' => null])

<div class="relative max-h-max min-h-52 w-full border flex items-center justify-center rounded-xl" x-data="{ openImage: false, scale: 1, offsetX: 0, offsetY: 0, filePreview: '{{ $file }}', previewImage: null }"
    x-init="previewImage = $refs.previewImage">
    @if (is_null($file))
        <div class="flex items-center justify-center w-full h-full">
            <p class="text-gray-400">Tidak ada foto</p>
        </div>
    @else
        <div class="absolute w-full h-full">
            <img @click="openImage = !openImage" :src="filePreview" alt="Gagal memuat gambar"
                class="w-full h-full object-contain flex items-center justify-center" draggable="false">
            <div x-show="openImage"
                class="fixed z-[9999999] top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
                <img x-show="openImage" x-ref="previewImage" :src="filePreview" alt="Gagal memuat gambar"
                    class="max-w-full max-h-full">
                <button type="button" @click.prevent="openImage = false"
                    class="absolute top-10 right-10 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 5.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="absolute bottom-2 w-full">
                    <div class="flex justify-center items-center">
                        <div class="rounded-xl bg-white h-12">
                            <button
                                @click="if (scale < 5) {scale += 0.1; previewImage.style.transform = `scale(${scale}) translate(${offsetX}px, ${offsetY}px)`;}"
                                class="bg-white-400 px-3 py-1 border-r h-full"><x-heroicon-o-magnifying-glass-plus
                                    class="w-6 h-6 text-black hover:text-gray-600" /></button>
                            <button
                                @click="if (scale > 0.2) { scale -= 0.1; previewImage.style.transform = `scale(${scale}) translate(${offsetX}px, ${offsetY}px)`; }"
                                class="bg-white-400 px-3 py-1 h-full"><x-heroicon-o-magnifying-glass-minus
                                    class="w-6 h-6 text-black hover:text-gray-600" /></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
