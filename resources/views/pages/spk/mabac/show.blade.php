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
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['decisionMatrix']">
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
                <x-decision-support-table :emptyColumn="true" stepTitle="Normalisasi Matriks (X)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['normalized']">
                    <p class="break-words">Normalisasi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">Jenis Kriteria Benefit: $$t_{ij} = {X_{ij} - X^-_{ij}
                            \over X^+_{ij} - X^-_{ij}}$$</p>
                        <p class="border border-black p-2 w-full">Jenis Kriteria Cost: $$t_{ij} = {X_{ij} - X^+_{ij}
                            \over X^-_{ij} - X^+_{ij}}$$</p>
                    </div>
                    <hr>
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
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(X_{ij}, X_{i^+}, X_{i^-} = \) menyajikan elemen matriks keputusan awal(X), dimana \(X_{i^+}
                            \) dan \(X_{i^-}\) didefinisikan sebagai berikut:</p>
                        <p>\(X_{i^+} = \) \(max(x1, x2, x3, ..., x_{m})\) mewakili nilai maksimum dari alternatif</p>
                        <p>\(X_{i^-} = \) \(min(x1, x2, x3, ..., x_{m})\) mewakili nilai minimum dari alternatif</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Tertimbang (V)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['weightedMatrix']" :withWeight="true" :weights="$weights">
                    <p class="break-words">Matriks tertimbang (V) di dapatkan dengan menggunakan rumus:</p>
                    <p class="border border-black p-2 w-full">$$v_{ij} = (w_{i} * t_{ij}) + w_{i}$$</p>
                    <hr>
                    <p>$$V =
                        \begin{bmatrix}
                        v_{11} & v_{12} & ... & v_{1n}\\
                        v_{11} & v_{22} & ... & v_{2n}\\
                        ... & ... & ... & ...\\
                        v_{m1} & v_{m2} & ... & v_{mn}
                        \end{bmatrix}$$</p>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(w_{i} = \) menyajikan elemen matriks yang dinormalisasi (N)</p>
                        <p>\(t_{ij} = \) menyajikan koefisien bobot kriteria</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="false" stepTitle="Matriks Area Perkiraan Batas (G)"
                    :columns="$criterias" :withAlternative="false" :data="$data['borderForecastAreaMatrix']">
                    <p class="break-words">Matriks area perkiraan batas untuk setiap kriteria ditentukan dengan
                        menggunakan rumus:</p>
                    <p class="border border-black p-2 w-full">$$g_{i} = \left(\prod_{j=1}^{m} \
                        v_{ij}\right)^\frac{1}{m}$$</p>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(v_{ij} = \) menampilkan elemen matriks terbbobot (V), "m" menyajikan jumlah total
                            alternatif</p>
                    </div>
                    <hr>
                    <p>Setelah menghitung nilai \(g_{i}\) untuk setiap kriteria, membantuk matriks daerah perkiraan
                        batas (G) dalam bentuk n x 1 ("n" menyajikan jumlah total kriteria yang dilakukan pemilihan
                        alternatif yang ditawarkan)</p>
                    <p>$$G = \begin{array}{c}
                        & \begin{matrix}
                        C_{1} & C_{2} & ... & C_{n}
                        \end{matrix} \\
                        &
                        \begin{bmatrix}
                        g_{1} & g_{2} & ... & g_{n}\\
                        \end{bmatrix}
                        \end{array}$$</p>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Jarak Alternatif (Q)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['alternativeDistanceMatrix']">
                    <p class="break-words">Jarak alternatif dari daerah perbatasan perkiraan (\(q_{ij}\))
                        ditentukan sebagai perbedaan elemen matriks tertimbang (V) dan nilai daerah perkiraan perbatasan
                        (G).
                    </p>
                    <p class="border border-black p-2 w-full">$$Q = V - G$$</p>
                    <hr>
                    <p>Yang dapat ditulis dengan cara lain:</p>
                    <p>$$G =
                        \begin{bmatrix}
                        v_{11} \ - \ g_{1} & v_{12} \ - \ g_{2} & ... & v_{1n} \ - \ g_{n}\\
                        v_{21} \ - \ g_{1} & v_{22} \ - \ g_{2} & ... & v_{2n} \ - \ g_{n}\\
                        ... & ... & ... & ...\\
                        v_{m1} \ - \ g_{1} & v_{m2} \ - \ g_{2} & ... & v_{mn} \ - \ g_{n}
                        \end{bmatrix}$$</p>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="false" stepTitle="Perankingan" :columns="['Kegiatan', 'Skor', 'Ranking']"
                    setColumnAs="Custom" :withAlternative="false" :data="$data['rankingMatrix']">
                    <p class="break-words">perhitungan nilai-nilai fungsi kriteria dengan alternatif diperoleh sebagai
                        jumlah dari jarak alternatif dari daerah perkiraan perbatasan (\(q_{ij}\)). Menjumlahkan elemen
                        matriks Q dengan garis diperoleh nilai akhir dari fungsi kriteria alternatif.
                    </p>
                    <p class="border border-black p-2 w-max md:w-full">$$S_{i} = \sum_{j=1}^{n} q_{ij}, j = 1, 2, ...,
                        n, i = 1, 2, ..., m$$</p>
                    <p>dimana "n" menyajikan jumlah kriteria, "m" menyajikan sejumlah alternatif</p>
                </x-decision-support-table>
            </section>

        </div>
    </div>

    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @endpush
</x-app-layout>
