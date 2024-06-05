<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div x-data="{ method: '{{ $method }}' }" x-init="getData('{{ $method }}')" class="p-6 rounded-xl bg-white-snow overflow-hidden">

            <section>
                <div class="overflow-x-auto">
                    <div class="grid grid-cols-8 w-max gap-5 py-5">
                        <button class="p-5" @click.prevent="method = 'all'; getData(method)"
                            :class="method == 'all' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">Semua</button>
                        {{-- <button class="p-5" @click.prevent="method = 'edas'; getData(method)"
                            :class="method == 'edas' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">EDAS</button> --}}
                        {{-- <button class="p-5" @click.prevent="method = 'mabac'; getData(method)"
                            :class="method == 'mabac' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">MABAC</button> --}}
                        <button class="p-5" @click.prevent="method = 'moora'; getData(method)"
                            :class="method == 'moora' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">MOORA</button>
                        <button class="p-5" @click.prevent="method = 'aras'; getData(method)"
                            :class="method == 'aras' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">ARAS</button>
                        <button class="p-5" @click.prevent="method = 'saw'; getData(method)"
                            :class="method == 'saw' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">SAW</button>
                        <button class="p-5" @click.prevent="method = 'smart'; getData(method)"
                            :class="method == 'smart' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">SMART</button>
                        <button class="p-5" @click.prevent="method = 'electre'; getData(method)"
                            :class="method == 'electre' ? 'border-b-2 font-bold text-azure-blue border-azure-blue' : ''">ELECTRE</button>

                    </div>
                </div>
            </section>

            {{-- Table --}}
            <section>
                <div x-show="method == 'edas'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'edas') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="edas-container">

                    </div>
                </div>

                <div x-show="method == 'mabac'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'mabac') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="mabac-container"></div>
                </div>

                <div x-show="method == 'moora'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'moora') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="moora-container"></div>
                </div>

                <div x-show="method == 'aras'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'aras') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="aras-container"></div>
                </div>

                <div x-show="method == 'saw'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'saw') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="saw-container">

                    </div>
                </div>

                <div x-show="method == 'smart'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'smart') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="smart-container">

                    </div>
                </div>

                <div x-show="method == 'electre'">
                    <div class="grid grid-cols-2 justify-center items-center mt-10">
                        <h1 class="text-lg font-bold">Perankingan</h1>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('spk.show.method', 'electre') }}"
                                class="px-4 py-2 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Detail</a>
                        </div>
                    </div>
                    <div id="electre-container">

                    </div>
                </div>

                <div x-show="method == 'all'">
                    <div id="all-container"></div>
                </div>
            </section>
            {{-- End Table --}}
        </div>
    </div>

    @push('scripts')
        <script>
            const getData = (metode) => {
                document.getElementById('loading').classList.replace('hidden', 'flex')
                fetch(`/api/v1/pendukung-keputusan/ranking/metode/${metode}`)
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById(`${metode}-container`).innerHTML = (metode.includes("metode") ?
                            `<h1 class="text-center p-5 text-red-500">${res.data}</h1>` : content(res, metode));
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                    })
                    .catch(err => {
                        pushNotification('error', 'Terjadi kesalahan saat mengambil data')
                        document.getElementById('loading').classList.replace('flex', 'hidden')
                    })
            }

            const content = (data, metode) => {
                let allRows = '';
                let rows = '';

                if (metode === 'all') {
                    const a = {};
                    data.data.forEach((metode) => {
                        metode.ranking.forEach((rank) => {
                            const alternatif = rank.Alternatif;
                            const ranks = rank.Ranking;

                            if (!a[alternatif]) {
                                a[alternatif] = {
                                    alternatif: alternatif,
                                    // edas: null,
                                    moora: null,
                                    aras: null,
                                    saw: null,
                                    electre: null
                                };
                            }

                            switch (metode.metode) {
                                // case 'Evaluation Based on Distance From Average Solution (EDAS)':
                                //     a[alternatif].edas = ranks;
                                //     break;
                                case 'Multi-Objective Optimization by Ratio Analysis (MOORA)':
                                    a[alternatif].moora = ranks;
                                    break;
                                case 'Additive Ratio Assesment (ARAS)':
                                    a[alternatif].aras = ranks;
                                    break;
                                case 'Simple Additive Weighted (SAW)':
                                    a[alternatif].saw = ranks;
                                    break;
                                case 'Simple Multi Attribute Rating Technique (SMART)':
                                    a[alternatif].smart = ranks;
                                    break;
                                case 'ELimination Et Choix TRaduisant la realitE (ELECTRE)':
                                    a[alternatif].electre = ranks;
                                    break;
                            }
                        });
                    });

                    allRows = Object.values(a).map(item => `
                    <tr>
                        <td class="p-5">${item.alternatif}</td>
                        <td class="p-5">${item.moora !== null ? item.moora : ''}</td>
                        <td class="p-5">${item.aras !== null ? item.aras : ''}</td>
                        <td class="p-5">${item.saw !== null ? item.saw : ''}</td>
                        <td class="p-5">${item.smart !== null ? item.smart : ''}</td>
                        <td class="p-5">${item.electre !== null ? item.electre : ''}</td>
                    </tr>
                `).join('');
                } else {
                    data.data.ranking.forEach((alternative) => {
                        rows += `
                        <tr>
                            <td class="p-5">${alternative.Alternatif}</td>
                            <td class="p-5">${alternative.Score}</td>
                            <td class="p-5">${alternative.Ranking}</td>
                        </tr>
                    `;
                    });
                }

                if (metode === 'all') {
                    return `
                    <div class="overflow-x-auto">
                        <table class="mt-6 table-auto rounded-t-xl overflow-hidden w-max md:w-full">
                            <thead>
                                <tr class="text-left bg-blue-gray ">
                                    <th class="p-5 truncate">Alternatif</th>
                                    <th class="p-5 truncate">MOORA</th>
                                    <th class="p-5 truncate">ARAS</th>
                                    <th class="p-5 truncate">SAW</th>
                                    <th class="p-5 truncate">SMART</th>
                                    <th class="p-5 truncate">ELECTRE</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${allRows}
                            </tbody>
                        </table>
                    </div>`;
                } else {
                    return `
                    <div class="overflow-x-auto">
                        <table class="mt-6 table-auto rounded-t-xl overflow-hidden w-max md:w-full">
                            <thead>
                                <tr class="text-left bg-blue-gray ">
                                    <th class="p-5 truncate">Alternatif</th>
                                    <th class="p-5 truncate">Skor</th>
                                    <th class="p-5 truncate">Ranking</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${rows}
                            </tbody>
                        </table>
                    </div>`;
                }
            }
        </script>
    @endpush
</x-app-layout>
