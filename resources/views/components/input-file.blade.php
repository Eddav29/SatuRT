@props([
    'name',
    'multiple' => false,
    'accept' => 'png,jpg,jpeg,webp,pdf,txt,doc,docx,xls,xlsx,csv,ppt,pptx',
    'fileSize' => env('FILE_UPLOAD_SIZE', '2000'),
    'maxFiles',
    'default',
    'identifier',
])

@php
    $randFunction = 'fileUpload' . Str::random(10);
    $name = $multiple ? $name . '[]' : $name;
@endphp

<div class="flex flex-col items-end font-sans w-full">
    <div class="flex gap-5 text-gray-500">
        <span>Maximun file size: @if ($fileSize >= 1000)
                {{ $fileSize / 1000 }} MB
            @elseif ($fileSize < 1000 && $fileSize >= 100)
                {{ $fileSize }} KB
            @else
                {{ $fileSize }} B
            @endif,</span>
        @isset($maxFiles)
            <span>Maximun file upload: {{ $maxFiles }},</span>
        @endisset
        <span>Extension: {{ $accept }}</span>
    </div>
    <div class="bg-white border border-gray-300 w-full h-fit rounded-md flex flex-col items-center"
        x-data="{{ $randFunction }}()">
        <div id="drop-area" class="relative w-full h-full py-10" @dragover.prevent @drop.prevent="">
            <input type="file" name="{{ $name }}" id="images"
                @if ($multiple) multiple @endif x-ref="fileInput" @change="handleFileUpload($event)"
                class="absolute top-0 w-full h-full opacity-0 z-10 cursor-pointer ">
            <div class="flex flex-col justify-center items-center w-full h-full space-y-6">
                <div class="bg-blue-100 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                </div>
                <h3 class="text-md font-normal text-blue-500">Drag &amp; drop files here</h3>
                <span class="text-sm">- OR -</span>
                <label for="images" class="cursor-pointer">
                    <span class="font-bold">Browse</span>
                </label>
            </div>
            @if (!$multiple)
                <div class="w-full h-full absolute z-20 top-0" x-show="filesListPreview !== null">
                    <template x-if="filesListPreview !== null">
                        <div class="w-auto h-full flex flex-col items-center relative border border-black rounded-md"
                            x-data="{ showTooltip: false }" @mouseover="showTooltip = true"
                            @mouseleave="showTooltip = !showTooltip">
                            <template x-if="filesListPreview.type.includes('image')">
                                <img @click="showImage(0)" :src="filesListPreview?.url" alt="image"
                                    class="object-contain w-full h-full">
                            </template>
                            <template x-if="filesListPreview.type.includes('pdf')">
                                <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-pdf.png" alt=""
                                    @click="window.open(filesListPreview?.url, '_blank')"
                                    class="object-contain w-full h-full">
                            </template>
                            <template x-if="filesListPreview.type.includes('text')">
                                <a class="w-full h-full" :href="filesListPreview?.url" download
                                    :title="filesListPreview.name" target="_blank">
                                    <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-txt.png" alt="Text File"
                                        class="object-contain w-full h-full">
                                </a>
                            </template>
                            <template x-if="filesListPreview.type.includes('spreadsheet')">
                                <a class="w-full h-full" :href="filesListPreview?.url" download
                                    :title="filesListPreview.name" target="_blank">
                                    <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-excel.png" alt="Excel File"
                                        class="object-contain w-full h-full">
                                </a>
                            </template>
                            <template x-if="filesListPreview.type.includes('word')">
                                <a class="w-full h-full" :href="filesListPreview?.url" download
                                    :title="filesListPreview.name" target="_blank">
                                    <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-word.png" alt="Word Document"
                                        class="object-contain w-full h-full">
                                </a>
                            </template>
                            <template x-if="filesListPreview.type.includes('presentation')">
                                <a class="w-full h-full" :href="filesListPreview?.url" download
                                    :title="filesListPreview.name" target="_blank">
                                    <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-ppt.png"
                                        alt="PowerPoint Presentation" class="object-contain w-full h-full">
                                </a>
                            </template>
                            <template x-else>
                                <a class="w-full h-full" :href="filesListPreview?.url" download
                                    :title="filesListPreview.name" target="_blank">
                                    <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-file.png" alt="File"
                                        class="object-contain w-full h-full">
                                </a>
                            </template>
                            <div :class="{ 'hidden': !showTooltip }"
                                class="absolute -top-6 bg-gray-700 text-[.7rem] font-thin text-white rounded-full px-2 line-clamp-1 max-w-96 w-fit">
                                <span x-text="filesListPreview.name"></span>
                            </div>
                            <button class="absolute -top-0 -right-0 z-[999999999]" @click.remove="removeFile(0)">
                                <x-heroicon-c-x-circle class="w-6 h-6 text-gray-700 hover:text-gray-500" />
                            </button>
                        </div>
                    </template>
                </div>
            @endif
        </div>
        @if ($multiple)
            <div class="w-full flex flex-wrap items-center justify-start gap-5 py-6 px-4" x-show="filesList.length > 0">
                <template x-for="(file, index) in filesListPreview" :key="index">
                    <div class="w-24 h-24 flex flex-col relative border border-black rounded-md" x-data="{ showTooltip: false }"
                        @mouseover="showTooltip = true" @mouseleave="showTooltip = !showTooltip">
                        <template x-if="file.type.includes('image') || file.type.includes('svg')">
                            <img @click="showImage(index)" :src="file.url" alt="image"
                                class="object-contain w-full h-full">
                        </template>
                        <template x-if="file.type.includes('pdf')">
                            <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-pdf.png" alt=""
                                @click="window.open(file.url, '_blank')" class="object-contain w-full h-full">
                        </template>
                        <template x-if="file.type.includes('text')">
                            <a :href="file.url" download :title="file.name" target="_blank">
                                <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-txt.png" alt="Text File"
                                    class="object-contain w-full h-full">
                            </a>
                        </template>
                        <template x-if="file.type.includes('spreadsheet')">
                            <a :href="file.url" download :title="file.name" target="_blank">
                                <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-excel.png" alt="Excel File"
                                    class="object-contain w-full h-full">
                            </a>
                        </template>
                        <template x-if="file.type.includes('word')">
                            <a :href="file.url" download :title="file.name" target="_blank">
                                <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-word.png" alt="Word Document"
                                    class="object-contain w-full h-full">
                            </a>
                        </template>
                        <template x-if="file.type.includes('presentation')">
                            <a :href="file.url" download :title="file.name" target="_blank">
                                <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-ppt.png"
                                    alt="PowerPoint Presentation" class="object-contain w-full h-full">
                            </a>
                        </template>
                        <template
                            x-if="!(file.type.includes('image') || file.type.includes('pdf') || file.type.includes('text') || file.type.includes('spreadsheet') || file.type.includes('word') || file.type.includes('presentation'))">
                            <a :href="file.url" download :title="file.name" target="_blank">
                                <img src="{{env('APP_URL', 'http://127.0.0.1:8000') }}/assets/images/icon-file.png" alt="File"
                                    class="object-contain w-full h-full">
                            </a>
                        </template>
                        <div :class="{ 'hidden': !showTooltip }"
                            class="absolute -top-6 bg-gray-700 text-[.7rem] font-thin text-white rounded-full px-2 line-clamp-1 max-w-96 w-fit">
                            <span x-text="file.name"></span>
                        </div>
                        <button class="absolute -top-2 -right-2 z-[997]" @click.prevent="removeFile()">
                            <x-heroicon-c-x-circle class="w-6 h-6 text-gray-700 hover:text-gray-500" />
                        </button>
                    </div>
                </template>
            </div>
        @endif
        <div>
            <div x-show="openImage" x-cloak
                class="fixed z-[9999999999] top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
                <img x-show="openImage" x-ref="previewImage" alt=""
                    class="rounded-xl max-w-full max-h-full">
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
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
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
            openImage: false,
            filesList: @if ($multiple)
                []
            @else
                null
            @endif ,
            filesListPreview: @if ($multiple)
                []
            @else
                null
            @endif ,
            allowedExtension: @if ($accept)
                ["{!! str_replace(',', "','", $accept) !!}"]
            @else
                []
            @endif ,
            size: @if ($fileSize >= 1000)
                {{ $fileSize / 1000 }} * 1024 * 1024
            @elseif ($fileSize < 1000 && $fileSize >= 100) {{ $fileSize }} * 1024
            @else
                {{ $fileSize }}
            @endif ,
            maxFiles: {{ $maxFiles ?? 0 }},

            init() {
                this.fileInput = this.$refs.fileInput;
                this.previewImage = this.$refs.previewImage;
                const dataTransfer = new DataTransfer();
                @isset($default)
                    @if ($multiple)
                        @foreach ($default as $file)
                            this._urlToFile('{{ $file[$identifier] }}').then(file => {
                                if (this._processFile(file)) {
                                    dataTransfer.items.add(file);
                                }
                            });
                        @endforeach
                        this.fileInput.files = Array.from(dataTransfer.files);
                    @else
                        this._urlToFile('{{ $default }}').then(file => {
                            if (this._processFile(file)) {
                                this.filesList = file;
                                dataTransfer.items.add(file);
                                this.fileInput.files = dataTransfer.files;
                            }
                        });
                    @endif
                @endisset

            },
            async _urlToFile(url) {
                try {
                    const response = await fetch(url, {
                        headers: {
                            'Access-Control-Allow-Origin': '*'
                        }
                    });
                    // Check if the response status is 404
                    if (response.status === 404) {
                        pushNotification('error', 'Failed to load file. Status: 404 Not Found');
                        return;
                    } else if (!response.ok) {
                        pushNotification('error', 'Failed to load file.');
                        return;
                    }
                    const blob = await response.blob();
                    return new File([blob], url.split('/').pop(), {
                        type: blob.type,
                    });
                } catch (error) {
                    pushNotification('error', 'Failed to load file.');
                }
            },

            showImage(index = 0) {
                console.log(this.filesListPreview.target)
                this.openImage = true;
                this.previewImage.src =
                    @if ($multiple)
                        this.filesListPreview[index].url
                    @else
                        this.filesListPreview.url
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

            removeFile(index) {
                @if ($multiple)
                    this.filesList.splice(index, 1);
                    this.filesListPreview.splice(index, 1);
                    const dataTransfer = new DataTransfer();

                    this.filesList.forEach(file => {
                        dataTransfer.items.add(file);
                    });

                    this.$refs.fileInput.files = dataTransfer.files;
                @else
                    this.filesList = null;
                    this.filesListPreview = null;
                    this.$refs.fileInput.value = null;
                @endif
            },

            handleFileUpload(event) {
                if (this.maxFiles > 0 && this.filesList.length >= this.maxFiles) {
                    pushNotification('error', 'Maximum file upload limit reached.');
                    return;
                }
                @if ($multiple)
                    this.handleMultipleFileUpload(event);
                @else
                    this.handleSingleFileUpload(event);
                @endif
            },

            handleSingleFileUpload(event) {
                const file = event.target.files[0];
                this._processFile(file);
            },

            _processFile(file) {
                const extension = this._getFileExtension(file.name);
                const isValidExtension = this._isExtensionValid(extension);
                if (isValidExtension && file.size <= this.size) {
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
                            this.filesListPreview.push({
                                name: file.name,
                                size: file.size,
                                type: file.type,
                                url: URL.createObjectURL(file),
                            });
                        @else
                            this.filesListPreview = {
                                name: file.name,
                                size: file.size,
                                type: file.type,
                                url: URL.createObjectURL(file),
                            };
                        @endif
                        return true;
                    } else {
                        pushNotification('error', 'File ' + file.name + ' already exists.');
                    }
                } else {
                    if (!isValidExtension) {
                        pushNotification('error', 'File type not supported: ' + extension);
                    } else {
                        pushNotification('error', 'File ' + file.name +
                            ' size is too large. Maximum file size is {{ $fileSize }} MB.');
                    }
                }
                return false;
            },

            handleMultipleFileUpload(event) {
                const newFiles = Array.from(event.target.files);
                const dataTransfer = new DataTransfer();

                // Add existing files to the DataTransfer object
                this.filesList.forEach(file => {
                    dataTransfer.items.add(file);
                });

                // Process and add new files to the DataTransfer object
                newFiles.forEach(file => {
                    if (this._processFile(file)) {
                        dataTransfer.items.add(file);
                    }
                });

                event.target.files = dataTransfer.files;
                this.filesList = Array.from(dataTransfer.files);
            },


            _isExtensionValid(extension) {
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
