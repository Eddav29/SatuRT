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
                <x-decision-support-table stepTitle="Average Solution (AV)" setColumnAs="Custom" :columns="['Kriteria', 'AV', 'Nilai']"
                    :withAlternative="false" :data="$data['average']">
                    <p class="break-words">Menentukan solusi rata-rata (AV) sesuai dengan kriteria yang ditentukan
                        dengan menggunakan persamaan berikut:</p>
                    <p class="border border-black p-2 w-full">$$AV_{j} = {\frac{\sum_{i=1}^m X_{ij}}{m}}$$</p>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(AV_{j} = \) solusi rata-rata</p>
                        <p>\(X_{ij} = \) nilai kriteria dari alternatif</p>
                        <p>\(m = \) alternatif</p>
                    </div>
                </x-decision-support-table>
            </section>


            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Jarak Positif dari Rata-rata (PDA)"
                    :columns="$criterias" :withAlternative="true" :alternatives="$alternatives" :data="$data['pda_nda']['pda']" :withWeight="true"
                    :weights="$weights">
                    <p class="break-words">Menghitung jarak positif dari matriks rata-rata (PDA) sesuai dengan kriteria
                        (benefit dan cost) dengan menggunakan persamaan berikut:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">Jenis Kriteria Benefit: $$PDA_{ij} = \left\{
                            \frac{max\left( 0, \left( x_{ij} - AV_{j} \right) \right)}{AV_{j}} \right\}$$</p>
                        <p class="border border-black p-2 w-full">Jenis Kriteria Cost: $$PDA_{ij} = \left\{
                            \frac{max\left( 0, \left( AV_{j} - x_{ij} \right) \right)}{AV_{j}} \right\}$$</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Jarak Negatif dari Rata-rata (NDA)"
                    :columns="$criterias" :withAlternative="true" :alternatives="$alternatives" :data="$data['pda_nda']['nda']" :withWeight="true"
                    :weights="$weights">
                    <p class="break-words">Menghitung jarak negatif dari matriks rata-rata (NDA) sesuai dengan kriteria
                        (benefit dan cost) dengan menggunakan persamaan berikut:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">Jenis Kriteria Benefit: $$NDA_{ij} = \left\{
                            \frac{max\left( 0, \left( AV_{j} - x_{ij} \right) \right)}{AV_{j}} \right\}$$</p>
                        <p class="border border-black p-2 w-full">Jenis Kriteria Cost: $$NDA_{ij} = \left\{
                            \frac{max\left( 0, \left( x_{ij} - AV_{j} \right) \right)}{AV_{j}} \right\}$$</p>

                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table stepTitle="Jumlah Terbobot dari PDA/NDA (SP/SN)" setColumnAs="Custom"
                    :columns="['Alternatif', 'SP', 'SN']" :withAlternative="false" :data="$data['spsn']">
                    <p class="break-words">Menentukan jumlah terbobot dari PDA dan NDA untuk semua alternatif dengan
                        persamaan berikut:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$SP_{i} = \sum_{j=1}^{n} \times PDA_{ij}$$</p>
                        <p class="border border-black p-2 w-full">$$SN_{i} = \sum_{j=1}^{n} \times NDA_{ij}$$</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table stepTitle="Normalisasi Nilai SP/SN (NSP/NSN)" setColumnAs="Custom"
                    :columns="['Alternatif', 'NSP', 'NSN']" :withAlternative="false" :data="$data['nspnsn']">
                    <p class="break-words">Menentukan nilai normalisasi dari SP dan SN pada semua alternatif menggunakan
                        rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$NSP_{i} = \frac{SP_{i}}{max\left(SP_{i}\right)}$$
                        </p>
                        <p class="border border-black p-2 w-full">$$NSN_{i} = 1 -
                            \frac{SN_{i}}{max\left(SN_{i}\right)}$$</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table stepTitle="Nilai Skor Penilaian (AS)" setColumnAs="Custom" :columns="['Alternatif', 'AS']"
                    :withAlternative="false" :data="$data['AS']">
                    <p class="break-words">Menghitung nilai <i>Apraisal Score</i> penilaian dengan menggunakan persamaan
                        berikut:</p>
                    <p class="border border-black p-2 w-full">$$AS_{i} = \frac{1}{2} \left(NSP_{i} + NSN_{i} \right)$$
                    </p>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table stepTitle="Perankingan Alternatif" setColumnAs="Custom" :columns="['Alternatif', 'AS', 'Ranking']"
                    :withAlternative="false" :data="$data['ranking']">
                    <p class="break-words">Perankingan dari nilai skor penilaian AS dari nilai yang tertinggi hingga
                        yang terendah. Alternatif dengan <strong>nilai yang tinggi</strong> menunjukkan alternatif
                        terbaik.</p>
                </x-decision-support-table>
            </section>
        </div>
    </div>

    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @endpush
</x-app-layout>
