<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden flex flex-col gap-y-10">

            <div class="mt-5">
                <a href="{{ route('spk.decision-maker.index') }}"
                   class="px-5 py-3 text-soft-snow rounded-lg gap-x-5 bg-azure-blue transition-all duration-300">Kembali</a>
            </div>
            {{-- DecisionMatrix --}}
            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Matrix Keputusan (X)" :columns="$criterias"
                                          :withAlternative="false" :alternatives="$alternatives" :data="$data['decisionMatrix1']">
                <p class="break-words">Pada matriks keputusan (X), baris menunjukkan Alternatif dan kolom menunjukkan kriteria. Matriks keputusan menunjukkan kinerja dari masing-masing alternatif terhadap berbagai kriteria</p>
                {{-- startmath --}}
                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mi>X</mi>
                    <mo>=</mo>
                    <mrow>
                      <mo>[</mo>
                      <mtable columnalign="center center center center" rowspacing="4pt" columnspacing="1em">
                        <mtr>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mn>01</mn>
                              </mrow>
                            </msub>
                          </mtd>
                          <mtd>
                            <mo>&#x2026;<!-- … --></mo>
                          </mtd>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mn>0</mn>
                                <mi>j</mi>
                              </mrow>
                            </msub>
                          </mtd>
                          <mtd>
                            <mo>&#x2026;<!-- … --></mo>
                          </mtd>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mn>0</mn>
                                <mi>n</mi>
                              </mrow>
                            </msub>
                          </mtd>
                        </mtr>
                        <mtr>
                          <mtd>
                            <mo>&#x22EE;<!-- ⋮ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22F1;<!-- ⋱ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22EE;<!-- ⋮ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22F1;<!-- ⋱ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22EE;<!-- ⋮ --></mo>
                          </mtd>
                        </mtr>
                        <mtr>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mi>i</mi>
                                <mn>1</mn>
                              </mrow>
                            </msub>
                          </mtd>
                          <mtd>
                            <mo>&#x2026;<!-- … --></mo>
                          </mtd>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mi>i</mi>
                                <mi>j</mi>
                              </mrow>
                            </msub>
                          </mtd>
                          <mtd>
                            <mo>&#x2026;<!-- … --></mo>
                          </mtd>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mi>i</mi>
                                <mi>n</mi>
                              </mrow>
                            </msub>
                          </mtd>
                        </mtr>
                        <mtr>
                          <mtd>
                            <mo>&#x22EE;<!-- ⋮ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22F1;<!-- ⋱ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22EE;<!-- ⋮ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22F1;<!-- ⋱ --></mo>
                          </mtd>
                          <mtd>
                            <mo>&#x22EE;<!-- ⋮ --></mo>
                          </mtd>
                        </mtr>
                        <mtr>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mi>m</mi>
                                <mn>1</mn>
                              </mrow>
                            </msub>
                          </mtd>
                          <mtd>
                            <mo>&#x2026;<!-- … --></mo>
                          </mtd>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mi>m</mi>
                                <mn>2</mn>
                              </mrow>
                            </msub>
                          </mtd>
                          <mtd>
                            <mo>&#x2026;<!-- … --></mo>
                          </mtd>
                          <mtd>
                            <msub>
                              <mi>x</mi>
                              <mrow class="MJX-TeXAtom-ORD">
                                <mi>m</mi>
                                <mi>n</mi>
                              </mrow>
                            </msub>
                          </mtd>
                        </mtr>
                      </mtable>
                      <mo>]</mo>
                    </mrow>
                    <mo stretchy="false">(</mo>
                    <mi>i</mi>
                    <mo>=</mo>
                    <mn>0</mn>
                    <mo>,</mo>
                    <mn>1</mn>
                    <mo>,</mo>
                    <mn>2</mn>
                    <mo>,</mo>
                    <mo>.</mo>
                    <mo>.</mo>
                    <mo>.</mo>
                    <mo>,</mo>
                    <mi>m</mi>
                    <mo>;</mo>
                    <mi>j</mi>
                    <mo>=</mo>
                    <mn>1</mn>
                    <mo>,</mo>
                    <mn>2</mn>
                    <mo>,</mo>
                    <mo>.</mo>
                    <mo>.</mo>
                    <mo>.</mo>
                    <mo>,</mo>
                    <mi>n</mi>
                    <mo stretchy="false">)</mo>
                  </math>
                {{-- endMath --}}
                <p class="break-words">
                  Rumus untuk A0 jika benefit:
                  \[
                  x_{0j} = \max_i x_{ij}
                  \]
              </p>
              <p class="break-words">
                  Rumus untuk A0 jika cost:
                  \[
                  x_{0j} = \min_i (x_{ij}^*)
                  \]
              </p>


                  </x-decision-support-table>
            </section>
            {{-- endDecisionMatrix --}}
            {{----}}
            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Normalisasi Matrix (R)" :columns="$criterias"
                                          :withAlternative="false" :alternatives="$alternatives" :data="$data['normalizedMatrix']">
                      <p class="break-words">
                        Rumus untuk kriteria benefit:
                        \[
                        r_{ij} = \frac{x_{ij}}{\sum_{i=0}^{m} x_{ij}}; \quad j = 1, 2, ..., n
                        \]
                    </p>
                    <p class="break-words">
                        Rumus untuk kriteria cost (tahap pertama):
                        \[
                        x_{*ij} = \frac{1}{x_{ij}}; \quad i = 0, 1, 2, ..., m; \quad j = 1, 2, ..., n
                        \]
                    </p>
                    <p class="break-words">
                        Rumus untuk kriteria cost (tahap kedua):
                        \[
                        r_{ij} = \frac{x_{*ij}}{\sum_{i=0}^{m} x_{*ij}}; \quad j = 1, 2, ..., n
                        \]
                    </p>
                     </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table :emptyColumn="true" stepTitle="Normalisasi Bobot (D)" :columns="$criterias"
                                          :withAlternative="false" :alternatives="$alternatives" :data="$data['weightedMatrix']" :withWeight="true" :weights="$weights">
                <p class="break-words">
                    Rumus untuk matriks ternormalisasi terbobot:
                    \[
                    D = [d_{ij}]_{m \times n} = r_{ij} \cdot w_j; \quad i = 0, 1, 2, ..., m; \quad j = 1, 2, ..., n
                    \]
                </p>
                <p>
                  Dimana \( w_j \) adalah bobot (weight) dari kriteria ke \( j \).
                </p>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table stepTitle="Nilai Fungsi Optimum (S)" setColumnAs="Custom" :columns="['Alternatif', 'S']"
                    :withAlternative="false" :data="$data['siValues']">
                          <p class="break-words">
                              Rumus untuk nilai fungsi optimum:
                              \[
                              S_i = \sum_{j=1}^{n} d_{ij}; \quad i = 0, 1, 2, ..., m; \quad j = 1, 2, ..., n
                              \]
                          </p>
                          <p>
                            Dimana \( S_i \) adalah nilai fungsi optimum dari alternatif \( i \). Nilai terbesar adalah yang terbaik, dan nilai yang paling sedikit adalah yang terburuk. Dengan memperhitungkan proses, hubungan proporsional dengan nilai dan bobot kriteria yang diteliti berpengaruh pada hasil akhir. \( S_0 \) adalah fungsi optimum dari alternatif optimal.
                          </p>
                </x-decision-support-table>
            </section>
            <section>
                <x-decision-support-table stepTitle="Nilai Utility Ranking (K)" setColumnAs="Custom" :columns="['Alternatif', 'Nilai K','Ranking']"
                    :withAlternative="false" :data="$data['utilityRanking']">

                    <p class="break-words">
                      Rumus untuk nilai utilitas:
                      \[
                      K_i = \frac{S_i}{S_0}; \quad i = 0, 1, 2, ..., m
                      \]
                    </p>
                    <p>
                        Dimana \( S_i \) dan \( S_0 \) merupakan nilai kriteria optimasi. Nilai utilitas \( K_i \) berada dalam interval \([0, 1]\) dan nilai \( K \) terbesar merupakan nilai prioritas. Alternatif dengan nilai utilitas \( K \) terbesar menghasilkan alternatif terbaik dan berurutan sehingga menghasilkan rangking.
                    </p>
                </x-decision-support-table>
            </section>
        </div>
    </div>

    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    @endpush
</x-app-layout>
