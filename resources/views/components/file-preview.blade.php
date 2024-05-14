@props(['filesList', 'multiple' => false, 'identifier' => 'link', 'accept' => ''])

@php
    $randFunction = 'filePreview' . Str::random(10);
@endphp

<div x-data="{{ $randFunction }}()">
    <div class="w-full flex flex-wrap items-center justify-start gap-5 py-6 px-4">
        @if ($multiple)
            <template x-for="(file, index) in filesList" :key="index">
                <div class="w-24 h-24 flex flex-col relative border border-black rounded-md" x-data="{ showTooltip: false }"
                    @mouseover="showTooltip = true" @mouseleave="showTooltip = !showTooltip">
                    <template x-if="file.type.includes('image') || file.type.includes('svg')">
                        <img @click="showImage(index)" :src="file.url" alt="image"
                            class="object-contain w-full h-full">
                    </template>
                    <template x-if="file.type.includes('pdf')">
                        <img src="http://127.0.0.1:8000/assets/images/icon-pdf.png" alt=""
                            @click="window.open(file.url, '_blank')" class="object-contain w-full h-full">
                    </template>
                    <template x-if="file.type.includes('text')">
                        <a :href="file.url" download :title="file.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-txt.png" alt="Text File"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-if="file.type.includes('spreadsheet')">
                        <a :href="file.url" download :title="file.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-excel.png" alt="Excel File"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-if="file.type.includes('word')">
                        <a :href="file.url" download :title="file.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-word.png" alt="Word Document"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-if="file.type.includes('presentation')">
                        <a :href="file.url" download :title="file.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-ppt.png" alt="PowerPoint Presentation"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template
                        x-if="!(file.type.includes('image') || file.type.includes('pdf') || file.type.includes('text') || file.type.includes('spreadsheet') || file.type.includes('word') || file.type.includes('presentation'))">
                        <a :href="file.url" download :title="file.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-file.png" alt="File"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <p class="text-sm truncate overflow-ellipsis px-2" x-text="file.name"></p>
                    <div :class="{ 'hidden': !showTooltip }"
                        class="absolute -top-6 bg-gray-700 text-[.7rem] font-thin text-white rounded-full px-2 line-clamp-1 max-w-80 w-max">
                        <span x-text="file.name"></span>
                    </div>
                </div>
            </template>
        @else
            <template x-if="filesList !== null">
                <div class="w-24 h-24 flex flex-col relative border border-black rounded-md" x-data="{ showTooltip: false }"
                    @mouseover="showTooltip = true" @mouseleave="showTooltip = !showTooltip">
                    <template x-if="filesList.type.includes('image')">
                        <img @click="showImage(0)" :src="filesList.url" alt="image"
                            class="object-contain w-full h-full">
                    </template>
                    <template x-if="filesList.type.includes('pdf')">
                        <img src="http://127.0.0.1:8000/assets/images/icon-pdf.png" alt=""
                            @click="window.open(filesList.url, '_blank')" class="object-contain w-full h-full">
                    </template>
                    <template x-if="filesList.type.includes('text')">
                        <a :href="filesList.url" download :title="filesList.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-txt.png" alt="Text File"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-if="filesList.type.includes('spreadsheet')">
                        <a :href="filesList.url" download :title="filesList.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-excel.png" alt="Excel File"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-if="filesList.type.includes('word')">
                        <a :href="filesList.url" download :title="filesList.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-word.png" alt="Word Document"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-if="filesList.type.includes('presentation')">
                        <a :href="filesList.url" download :title="filesList.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-ppt.png" alt="PowerPoint Presentation"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <template x-else>
                        <a :href="filesList.url" download :title="filesList.name" target="_blank">
                            <img src="http://127.0.0.1:8000/assets/images/icon-file.png" alt="File"
                                class="object-contain w-full h-full">
                        </a>
                    </template>
                    <p class="text-sm truncate overflow-ellipsis px-2" x-text="filesList.name"></p>
                    <div :class="{ 'hidden': !showTooltip }"
                        class="absolute -top-6 bg-gray-700 text-[.7rem] font-thin text-white rounded-full px-2 line-clamp-1 max-w-80 w-max">
                        <span x-text="filesList.name"></span>
                    </div>
                </div>
            </template>
        @endif
    </div>

    <div>
        <div x-show="openImage" x-cloak
            class="fixed z-[9999999999] top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
            <img x-show="openImage" x-ref="previewImage" alt="" class="rounded-xl max-w-full max-h-full">
            <button type="button" @click.prevent="closeImage" class="absolute top-10 right-10 cursor-pointer">
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
                        <button @click="zoomIn()"
                            class="bg-white-400 px-3 py-1 border-r h-full"><x-heroicon-o-magnifying-glass-plus
                                class="w-6 h-6 text-black hover:text-gray-600" /></button>
                        <button @click="zoomOut()"
                            class="bg-white-400 px-3 py-1 h-full"><x-heroicon-o-magnifying-glass-minus
                                class="w-6 h-6 text-black hover:text-gray-600" /></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.{{ $randFunction }} = function() {
        return {
            offsetX: 0,
            offsetY: 0,
            scale: 1,
            fileInput: null,
            previewImage: null,
            filePreview: null,
            openImage: false,
            filesList: @if ($multiple)
                []
            @else
                null
            @endif ,
            allowedExtension: @if ($accept)
                ["{!! str_replace(',', "','", $accept) !!}"]
            @else
                []
            @endif,
            init() {
                this.previewImage = this.$refs.previewImage;
                @isset($filesList)
                    @if ($multiple)
                        @foreach ($filesList as $file)
                            this._urlToFile('{{ $file[$identifier] }}').then(file => {
                                this._processFile(file);
                            });
                        @endforeach
                    @else
                        this._urlToFile('{{ $default }}').then(file => {
                            this._processFile(file);
                        });
                    @endif
                @endisset
            },
            async _urlToFile(url) {
                try {
                    const response = await fetch(url);
                    const blob = await response.blob();
                    return new File([blob], url.split('/').pop(), {
                        type: blob.type,
                    });
                } catch (error) {
                    pushNotification('error', 'Failed to load file.');
                }
            },

            showImage(index) {
                this.openImage = true;
                this.previewImage.src =
                    @if ($multiple)
                        this.filesList[index].url
                    @else
                        this.filesList.url
                    @endif ;
            },

            closeImage() {
                this.openImage = false;
            },

            zoomIn() {
                if (this.scale < 5) {
                    this.scale += 0.1;
                    this.previewImage.style.transform =
                        `scale(${this.scale}) translate(${this.offsetX}px, ${this.offsetY}px)`;
                }
            },

            zoomOut() {
                if (this.scale > 0.2) {
                    this.scale -= 0.1;
                    this.previewImage.style.transform =
                        `scale(${this.scale}) translate(${this.offsetX}px, ${this.offsetY}px)`;
                }
            },

            _processFile(file) {
                const extension = this._getFileExtension(file.name);
                const isValidExtension = this._isExtensionValid(extension);
                if (isValidExtension) {
                    const existingFile =
                        @if ($multiple)
                            this.filesList.find(existingFile =>
                                existingFile.name === file.name &&
                                existingFile.size === file.size &&
                                existingFile.type === file.type
                            )
                        @else
                            (this.filesList !== null &&
                                this.filesList.name === file.name &&
                                this.filesList.size === file.size &&
                                this.filesList.type === file.type)
                        @endif ;


                    if (!existingFile) {
                        @if ($multiple)
                            this.filesList.push({
                                name: file.name,
                                size: file.size,
                                type: file.type,
                                url: URL.createObjectURL(file),
                            });
                        @else
                            this.filesList = {
                                name: file.name,
                                size: file.size,
                                type: file.type,
                                url: URL.createObjectURL(file),
                            };
                        @endif
                    } else {
                        pushNotification('error', 'File ' + file.name + ' already exists.');
                    }
                } else {
                    if (!isValidExtension) {
                        pushNotification('error', 'File type not supported: ' + extension);
                    } else {
                        pushNotification('error', 'Failed to load file.');
                    }
                }
            },

            _isExtensionValid(extension) {
                if (this.allowedExtension.length === 0) {
                    return true;
                }
                for (let key in this.allowedExtension) {
                    if (this.allowedExtension[key].includes(extension)) {
                        return true;
                    }
                }
                return false;
            },

            _getFileExtension(fileName) {
                return fileName.split('.').pop().toLowerCase();
            }
        };
    }
</script>
