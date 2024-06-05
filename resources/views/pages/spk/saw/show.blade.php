<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden flex flex-col gap-y-10">

            <div class="mt-5">
                <a href="{{ route('spk.decision-maker.index') }}"
                    class="px-5 py-3 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Kembali</a>
            </div>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Keputusan (X)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['decisionMatrix']" >
                    <p class="break-words">Pada Langkah pertama dilakukan evaluasi alternatif “m” dengan “n” kriteria.</p>
                    <p>$$X = \begin{array}{c}
                        & \begin{matrix}
                        C_{1} & C_{2} & ... & C_{n}
                        \end{matrix} \\
                        \begin{array}{c}
                        A_1\\
                        A_2\\
                        ...\\
                        A_3
                        \end{array}
                        &
                        \begin{pmatrix}
                        X_{11} & X_{12} & ... & X_{1m}\\
                        X_{11} & X_{22} & ... & X_{2n}\\
                        ... & ... & ... & ...\\
                        X_{1m} & X_{2m} & ... & X_{mn}
                        \end{pmatrix}
                        \end{array}$$</p>
                    <p class="flex flex-col">
                        Keterangan:
                        <span>m = nomor alternatif</span>
                        <span>n = jumlah total kriteria</span>
                    </p>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Normalisasi Matriks (r)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['normalized']">
                    <p class="break-words">Normalisasi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">Jenis Kriteria Benefit: $$r_{ij} = {X_{ij} \over Max X_{ij}}$$</p>
                        <p class="border border-black p-2 w-full">Jenis Kriteria Cost: $$r_{ij} = {Min X_{ij} \over X_{ij}}$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(r_{ij} = \) mewakili nilai ternormalisasi</p>
                        <p>\(Max X_{ij} = \) \(max(x1, x2, x3, ..., x_{m})\) mewakili nilai maksimum dari alternatif</p>
                        <p>\(Min X_{ij} = \) \(min(x1, x2, x3, ..., x_{m})\) mewakili nilai minimum dari alternatif</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Nilai Preferensi (v)" setColumnAs="Custom"
                :columns="['Relevansi', 'Dampak Sosial', 'Jumlah Panitia', 'Biaya', 'Kesulitan', 'V']"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['perhitunganNilaiPreferensi']">
                    <p class="break-words">Nilai Preferensi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$v_{i} = \sum_{j=1}^{n} \left({w_{j}  r_{ij}}\right)$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(v_{i} = \) mewakili nilai preferensi dari alternatif</p>
                        <p>\(w_{j} = \) mewakili nilai bobot dari kriteria</p>
                        <p>\(r_{ij} = \) mewakili nilai ternormalisasi</p>
                        <p>\(\sum_{j=1}^{n} \left(w_{j} r_{ij}\right)\ = \) mewakili jumlah hasil perkalian bobot dan nilai ternormalisasi</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table stepTitle="Perankingan Alternatif" setColumnAs="Custom" :columns="['Alternatif', 'V', 'Ranking']"
                    :withAlternative="false" :data="$data['ranking']">
                    <p class="break-words">Perangkingan Alternatif diambil dari nilai preferensi terbesar</p>
                    <hr>
                </x-decision-support-table>
            </section>
        </div>
    </div>

    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @endpush
</x-app-layout>
