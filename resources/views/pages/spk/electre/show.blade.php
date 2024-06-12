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
                    :withAlternative="true" :alternatives="$alternatives" :data="$data['decisionMatrix']" startIndex="0">
                    <p class="break-words">Pada Langkah pertama dilakukan evaluasi alternatif “m” dengan “n” kriteria.
                    </p>
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
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Normalisasi (R)" :columns="$criterias"
                    startIndex="0" :withAlternative="true" :alternatives="$alternatives" :data="$data['normalizationR']">
                    <p class="break-words">Normalisasi diperoleh dengan menggunakan rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$r_{ij} = \frac{X_{ij}}{\sqrt{\sum\limits_{i=1}^m
                            X_{ij}^2}}$$</p>
                        <p class="border border-black p-2 w-full">$$ R =
                            \begin{bmatrix}
                            r_{11} & r_{12} & ... & r_{1n}\\
                            r_{11} & r_{22} & ... & r_{2n}\\
                            ... & ... & ... & ...\\
                            r_{m1} & r_{m2} & ... & r_{mn}
                            \end{bmatrix}$$</p>
                    </div>
                    <hr>

                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(r_{ij} = \) matriks hasil normalisasi </p>
                        <p>\(X_{ij} = \) matriks dasar yang akan dinormalisasikan</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Pembobotan Matriks Normalisasi"
                    :columns="$criterias" :withWeight="true" :weights="$weights" startIndex="0" :withAlternative="true"
                    :alternatives="$alternatives" :data="$data['weightedNormalizationR']">
                    <p class="break-words">Pembobotan pada matriks yang telah dinormalisasi:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$RW =
                            \begin{bmatrix}
                            r_{1}w_{11} & r_{2}w_{12} & ... & r_{n}w_{1n}\\
                            r_{1}w_{11} & r_{2}w_{22} & ... & r_{n}w_{2n}\\
                            ... & ... & ... & ...\\
                            r_{1}w_{m1} & r_{2}w_{m2} & ... & r_{n}w_{mn}
                            \end{bmatrix}$$</p>
                        <p class="border border-black p-2 w-full">$$V =
                            \begin{bmatrix}
                            v_{11} & v_{12} & ... & v_{1n}\\
                            v_{11} & v_{22} & ... & v_{2n}\\
                            ... & ... & ... & ...\\
                            v_{m1} & v_{m2} & ... & v_{mn}
                            \end{bmatrix}$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>Setelah dinormalisasi, setiap kolom dari matriks R
                            dikalikan dengan bobot \( W_{j} \).</p>
                        <p>Sehingga rumus Weight normalized matrix \( V = R\,x\,W \)</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-decision-support-table stepTitle="Himpunan Matriks Concordance" setColumnAs="Custom"
                        :columns="['Kriteria', 'Index']" :data="$data['indexCriteria']['Concordance']">
                        <p class="break-words">Menentukan himpunan concordance:</p>
                        <div class="flex flex-col gap-y-2">
                            <p class="border border-black p-2 w-full">$$
                                C_{kl} = \{ j \mid v_{kj} \geq v_{ij} \text{ untuk } j = 1, 2, 3, \ldots, n \}
                                $$
                            </p>
                        </div>
                        <hr>
                        <div class="flex flex-col gap-y-5">
                            Keterangan:
                            <p>\( C_{kl} = \) Himpunan indeks \(_{𝑗} \) yang memenuhi syarat</p>
                            <p>\( v_{kj} \geq v_{ij} = \) Kondisi yang harus dipenuhi oleh
                                \(_{j}\). Artinya, elemen \(v_{kj}\) harus lebih besar atau sama dengan elemen
                                \(v_{ij}\)</p>
                            <p>\(j = 1,2,3,…,n\) Rentang nilai yang mungkin untuk \(j\), dari 1 hingga \(n\)</p>
                        </div>
                    </x-decision-support-table>
                </div>
                <div>
                    <x-decision-support-table stepTitle="Himpunan Matriks Discordance" setColumnAs="Custom"
                        :columns="['Kriteria', 'Index']" :data="$data['indexCriteria']['Discordance']">
                        <p class="break-words">Menentukan himpunan discordance:</p>
                        <div class="flex flex-col gap-y-2">
                            <p class="border border-black p-2 w-full">$$
                                D_{kl} = \{ j \mid v_{kj} < v_{ij} \text{ untuk } j=1, 2, 3, \ldots, n \} $$ </p>
                        </div>
                        <hr>
                        <div class="flex flex-col gap-y-5">
                            Keterangan:
                            <p>\( D_{kl} = \) Himpunan indeks \(_{𝑗} \) yang memenuhi syarat</p>
                            <p>\( v_{kj} < v_{ij}=\) Kondisi yang harus dipenuhi oleh \(_{j}\). Artinya, elemen
                                    \(v_{kj}\) harus kurang dari elemen \(v_{ij}\)</p>
                                    <p>\(j = 1,2,3,…,n\) Rentang nilai yang mungkin untuk \(j\), dari 1 hingga \(n\)</p>
                        </div>
                    </x-decision-support-table>
                </div>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Menentukan Matriks Concordance"
                    :columns="$alternatives" startIndex="0" :withAlternative="true" :alternatives="$alternatives" :data="$data['matrixConcordance']['C']">
                    <p class="break-words">Menentukan nilai matriks :</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$
                            C_{kl} = \sum_{j \in C_{kl}} W_j
                            $$
                        </p>
                        <p class="border border-black p-2 w-full">$$C =
                            \begin{bmatrix}
                            c_{11} & c_{12} & ... & c_{1n}\\
                            c_{11} & c_{22} & ... & c_{2n}\\
                            ... & ... & ... & ...\\
                            c_{m1} & c_{m2} & ... & c_{mn}
                            \end{bmatrix}$$</p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Menentukan Matriks Discordance"
                    :columns="$alternatives" startIndex="0" :withAlternative="true" :alternatives="$alternatives" :data="$data['matrixDiscordance']['D']">
                    <p class="break-words">Menentukan nilai normalisasi dari SP dan SN pada semua alternatif menggunakan
                        rumus:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$
                            d_{kl} = \frac{\max\{|v_{kj} - v_{lj}|\}_{j \in d_{kl}}}{\max\{|v_{kj} - v_{lj}|\}_{\forall
                            j}}
                            $$

                        </p>
                    </div>
                </x-decision-support-table>
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-decision-support-table stepTitle="Nilai Threshold (C)" :columns="['C']" :data="$data['thresholdMatrixConcordance']">
                        <p class="break-words">Menentukan nilai threshold matriks concordance:</p>
                        <div class="flex flex-col gap-y-2">
                            <p class="border border-black p-2 w-full">$$ C_{kl} \geq {}^C_{-} $$
                            </p>
                            <p class="border border-black p-2 w-full">$$
                                {}^C_{-} = \frac{\sum_{k=1}^{m} \sum_{l=1}^{m} C_{kl}}{m(m-1)}
                                $$</p>
                        </div>
                    </x-decision-support-table>
                </div>

                <div>
                    <x-decision-support-table stepTitle="Nilai Threshold (D)" :columns="['D']" :data="$data['thresholdMatrixDiscordance']">
                        <p class="break-words">Menentukan nilai threshold matriks discordance:</p>
                        <div class="flex flex-col gap-y-2">
                            <p class="border border-black p-2 w-full">$$ D_{kl} \geq {}^D_{-} $$
                            </p>
                            <p class="border border-black p-2 w-full">$$
                                {}^D_{-} = \frac{\sum_{k=1}^{m} \sum_{l=1}^{m} D_{kl}}{m(m-1)}
                                $$</p>
                        </div>
                    </x-decision-support-table>
                </div>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Dominan Concordance (F)"
                    :columns="$alternatives" startIndex="0" :withAlternative="true" :alternatives="$alternatives" :data="$data['matrixDominantConcordance']['F']">
                    <p class="break-words">Menentukan matriks dominan concordance:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$F =
                            \begin{bmatrix}
                            - & f_{12} & ... & f_{1n}\\
                            f_{11} & - & ... & f_{2n}\\
                            ... & ... & ... & ...\\
                            f_{m1} & f_{m2} & ... & -
                            \end{bmatrix}$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(f_{kl} = 1 \) jika \(c_{kl} >= {}^C_{-} \) dan \(f_{kl} = 0 \) jika \(c_{kl} < {}^C_{-} \)
                                </p>
                    </div>
                </x-decision-support-table>
            </section>

            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Dominan Discordance (G)"
                    :columns="$alternatives" startIndex="0" :withAlternative="true" :alternatives="$alternatives" :data="$data['matrixDominantDiscordance']['G']">
                    <p class="break-words">Menentukan matriks dominan discordance:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$G =
                            \begin{bmatrix}
                            - & g_{12} & ... & g_{1n}\\
                            g_{11} & - & ... & g_{2n}\\
                            ... & ... & ... & ...\\
                            g_{m1} & g_{m2} & ... & -
                            \end{bmatrix}$$</p>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>\(g_{kl} = 1 \) jika \(d_{kl} >= {}^D_{-} \) dan \(g_{kl} = 0 \) jika \(d_{kl} < {}^D_{-} \)
                                </p>
                    </div>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matriks Dominan Agregate (E)" :columns="array_merge($alternatives, ['Total'])"
                    startIndex="0" :withAlternative="true" :alternatives="$alternatives" :data="$data['aggregateMatrix']['E']">
                    <p class="break-words"> Matriks E didapatkan dari perkalian antara elemen matriks
                        F dengan elemen matriks G:</p>
                    <div class="flex flex-col gap-y-2">
                        <p class="border border-black p-2 w-full">$$
                            e_{kl} = f_{kl} \times g_{kl}
                            $$</p>

                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-5">
                        Keterangan:
                        <p>Matriks \(E\) didapatkan urutan pilihan dari setiap alternatif, yaitu
                            bila \(E_{kl}\) = 1 maka alternatif \(A_{k}\) merupakan alternatif yang lebih
                            baik dari \(A_{l}\)</p>
                        <p>
                            Sehingga baris dalam matriks \(E\) yang memiliki jumlah \(E_{kl}\) = 1 paling sedikit dapat
                            dieliminasi
                        </p>
                        <p>Dengan demikian, alternatif terbaik adalah <span class="font-semibold">alternatif yang
                                mendominasi alternatif lainnya</span></p>
                        <p>Jika hasil dari Matriks Dominan Bernilai 0 kita dapat melanjutkan perhitungan dengan
                            menggunakan rumus untuk perankingan:
                        </p>
                        <p class="border border-black p-2 w-full">$$
                            E_{k} = \sum_{k=1}^{m} \sum_{l=1}^{n} (C_{kl} - d_{kl})
                            $$</p>
                        <p>Dimana \(E_{k}\) merupakan nilai alternatif untuk perankingan. Alternatif dengan nilai
                            \(E_{k}\) yang tinggi menunjukkan alternatif terbaik
                            contoh perhitungan dapat dilihat pada tabel dibawah ini:
                        </p>
                    </div>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table stepTitle="Perankingan (Eliminasi alternatif yang less favourable)"
                    setColumnAs="Custom" :columns="array_keys($data['elimination'][0])" :withAlternative="false" :data="$data['elimination']">
                    <p class="break-words">Perankingan dari nilai skor penilaian E dari nilai yang tertinggi hingga
                        yang terendah. Alternatif dengan <strong>nilai yang tinggi</strong> menunjukkan alternatif
                        terbaik.</p>
                    <div>
                        <p class="text-sm text-gray-500">*Tidak Wajib jika Matriks Dominan sudah bernilai 1</p>
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
