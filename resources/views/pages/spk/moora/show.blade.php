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
                    <p class="break-words">Pada matriks keputusan (X) baris menunjukkan alternatif dan kolom menunjukkan
                        kriteria</p>
                    <p>$$X =
                        \begin{bmatrix}
                        X_{11} & ... & X_{12} & ... & X_{1n}\\
                        X_{21} & ... & X_{22} & ... & X_{2n}\\
                        X_{m1} & ... & X_{m2} & ... & X_{mn}
                        \end{bmatrix}$$</p>
                    <p class="flex flex-col">
                        Keterangan:
                        <span>m = alternatif</span>
                        <span>n = kriteria</span>
                    </p>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Normalisasi Matriks (X)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['normalizedMatrix']">
                    <p class="break-words">Normalisasi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="p-2 w-full">$$X^*_{ij} = 
                            \frac{X_{ij}}{\sqrt{\left[ \sum_{i=1+a+b}^m X^2_{ij} \right]}}$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(X_{ij} = \) nilai kriteria dari alternatif</p>
                        <p>\(m  = \) alternatif</p>
                    </div>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Optimasi Nilai Atribut (X)" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['weightedMatrix']">
                    <p class="break-words">Optimasi nilai atribut diperoleh menggunakan rumus berikut:</p>
                    <div class="flex flex-col gap-y-2">
                        <p>$$X^*_{ij} =
                            \begin{bmatrix}
                            X_{11} & ... & X_{12} & ... & X_{1n}\\
                            X_{21} & ... & X_{22} & ... & X_{2n}\\  
                            X_{m1} & ... & X_{m2} & ... & X_{mn}
                            \end{bmatrix} \times W_{j}$$</p>

                    </div>
                    <hr>

                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(X^*_{ij} = \) nilai matriks yang sudah ternormalisasi</p>
                        <p>\(W  = \) Bobot</p>
                    </div>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Menentukan Nilai Yi" :columns="['Nilai Benefit', 'Nilai Cost', 'Yi(Benefit-Cost)']"
                    :withAlternative="false" :alternatives="$alternatives" :data="$data['nilaiY(i)']">
                    <p class="break-words">Normalisasi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$Y_{i} = 
                            {\sum_{j=1}^g  w_{j}x^*_{ij}} - {\sum_{j=g+1}^n  w_{j} w^*_{ij}}\\ $$</p>
                    </div>
                    <hr>

                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(X^*_{ij} = \) Nilai Matriks Benefit Yang Sudah Ternormalisasi</p>
                        <p>\(w^*_{ij} = \) Nilai Matriks Cost Yang Sudah Ternormalisasi</p>
                        <p>\(w_{j}  = \) Bobot</p>
                        <p>\(g  = \) Jumlah Kriteria Benefit</p>
                        <p>\(n  = \) Jumlah Kriteria Cost</p>
                        <p>\(j  = \) Nilai Yang Berkisar Dari g + 1 Hingga n</p>
                        <p>\(w_{j}X^*_{ij} = \) Nilai Matriks Benefit Yang Sudah Ternormalisasi Dikali Dengan Bobot</p>
                        <p>\(w_{j}w^*_{ij} = \) Nilai Matriks Cost Yang Sudah Ternormalisasi Dikali Dengan Bobot</p>
                        <p>\(Y_{i} = \) Hasil Pengurangan Nilai Benefit Dengan Nilai Cost</p>
                    </div>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table  stepTitle="Perankingan" setColumnAs="Custom" :columns="['Alternatif', 'Yi(Benefit-Cost)', 'Ranking']"
                    :withAlternative="false" :alternatives="$alternatives" :data="$data['ranking']">
                    <div class="flex flex-col gap-y-2">
                        <p>Perankingan didapatkan dari nilai skor \(Y_{i}\) tertinggi hingga yang terendah. Alternatif dengan nilai yang tinggi menunjukkan alternatif terbaik.</p>
                    </div>
                </x-decision-support-table>
            </section>

            

        </div>
    </div>

    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @endpush
</x-app-layout>
