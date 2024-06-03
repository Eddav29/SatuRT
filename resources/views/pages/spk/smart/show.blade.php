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
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Keputusan (X)" :columns="$criterias" :withGuide=false
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['decisionMatrix']" >

                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table stepTitle="Normalisasi Matrix" setColumnAs="Custom" :columns="['Kode', 'Kriteria', 'Bobot', 'Hasil Normalisasi']"
                    :data="$data['normalizeMatrix']">
                    <p class="break-words">Pada Langkah pertama dilakukan evaluasi alternatif “m” dengan “n” kriteria.
                    </p>
                    <p class="border border-black p-2 w-max md:w-full">$$w_{j} = \frac{w_j}{\sum_{j=1}^{m} w_m} $$</p>
                    <p class="flex flex-col">
                        Keterangan:
                    <table>
                        <tbody>
                            <tr>
                                <td>\(w_{j}\)</td>
                                <td>=</td>
                                <td>Menghitung bobot kriteria</td>
                            </tr>
                            <tr>
                                <td>\(\sum_{j=1}^{m} w_m\)</td>
                                <td>=</td>
                                <td>Menghitung total bobot kriteria</td>
                            </tr>
                        </tbody>
                    </table>
                    </p>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Unity Matrix" :columns="$criterias"
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['unityMatrix']">
                    <p class="break-words">Normalisasi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">Jenis Kriteria Benefit: $$u_{i}(a_{i}) = {C_{cout} -
                            C_{min}
                            \over C_{max} - C_{min}}$$</p>
                        <p class="border border-black p-2 w-full">Jenis Kriteria Cost: $$u_{i}(a_{i}) = {C_{max} -
                            C_{out}
                            \over C_{max} - C_{min}}$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(C_{max} = \) Nilai kriteria maksimal</p>
                        <p>\(C_{min} = \) Nilai kriteria minimal</p>
                        <p>\(C_{out} = \) Nilai kriteria ke-i</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="false" stepTitle="Nilai Akhir dan Perankingan" :columns="['Kegiatan', 'Skor', 'Ranking']"
                    setColumnAs="Custom" :withAlternative="false" :data="$data['ranking']">
                    <p class="break-words">Untuk mendapatkan nilai akhir dari masing-masing alternatif yaitu dengan
                        mengalikan hasil nilai normalisasi dengan bobot alternatif. Kemudian hasil perkalian tersebut
                        dijumlahkan.
                    </p>
                    <p class="border border-black p-2 w-max md:w-full">$$u(a_{i}) = \sum_{j=1}^{m} w_{j}u_{i} (a_{i})$$
                    </p>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <table>
                            <tbody>
                                <tr>
                                    <td>\(u(a_{i})\)</td>
                                    <td>=</td>
                                    <td>Nilai total dari normalisasi dan bobot</td>
                                </tr>
                                <tr>
                                    <td>\(w_{j}\)</td>
                                    <td>=</td>
                                    <td>Hasil dari normalisasi bobot kriteria</td>
                                </tr>
                                <tr>
                                    <td>\(u_{i}(a_{i})\)</td>
                                    <td>=</td>
                                    <td>Nilai rata-rata dari normalisasi dan bobot</td>
                                </tr>
                            </tbody>
                        </table>
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
