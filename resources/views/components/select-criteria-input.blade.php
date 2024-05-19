@props([
    'criteriaName' => '',
    'name',
    'id',
    'lastCriteria' => false,
])

<div @click.outside="open = !open" @click="open = !open" x-show="open"
    class="rounded-2xl border border-blue-100 bg-white p-4 shadow-lg sm:p-6 lg:p-8 absolute -left-5 {{ $lastCriteria ? '-top-80' : '-top-5' }} w-[21rem] md:w-[30rem] z-50"
    role="alert">
    <div class="flex items-center gap-4">
        <span class="shrink-0 rounded-full bg-blue-400 p-2 text-white">
            <svg class="h-4 w-4" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                    d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"
                    fill-rule="evenodd" />
            </svg>
        </span>

        <p class="font-medium sm:text-lg">Keterangan Nilai</p>
    </div>

    <div class="mt-4 text-gray-500 flex flex-col gap-y-5 overflow-x-auto">
        @if ($criteriaName === 'Relevansi')
            <table class="table-auto rounded-t-xl overflow-hidden min-w-full w-max md:w-full text-left">
                <thead class="divide-y divide-gray-200">
                    <tr>
                        <th class="p-5">Nilai</th>
                        <th class="p-5">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="p-5">Sangat Relevan</td>
                        <td class="p-5">5</td>
                    </tr>
                    <tr>
                        <td class="p-5">Relevan</td>
                        <td class="p-5">4</td>
                    </tr>
                    <tr>
                        <td class="p-5">Netral</td>
                        <td class="p-5">3</td>
                    </tr>
                    <tr>
                        <td class="p-5">Tidak Relevan</td>
                        <td class="p-5">2</td>
                    </tr>
                    <tr>
                        <td class="p-5">Sangat Tidak Relevan</td>
                        <td class="p-5">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
        @if ($criteriaName === 'Dampak Sosial')
            <table class="table-auto rounded-t-xl overflow-hidden min-w-full w-max md:w-full text-left">
                <thead class="divide-y divide-gray-200">
                    <tr>
                        <th class="p-5">Nilai</th>
                        <th class="p-5">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="p-5">Sangat Tinggi</td>
                        <td class="p-5">5</td>
                    </tr>
                    <tr>
                        <td class="p-5">Tinggi</td>
                        <td class="p-5">4</td>
                    </tr>
                    <tr>
                        <td class="p-5">Cukup</td>
                        <td class="p-5">3</td>
                    </tr>
                    <tr>
                        <td class="p-5">Rendah</td>
                        <td class="p-5">2</td>
                    </tr>
                    <tr>
                        <td class="p-5">Sangat Rendah</td>
                        <td class="p-5">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
        @if ($criteriaName === 'Jumlah Panitia')
            <table class="table-auto rounded-t-xl overflow-hidden min-w-full w-max md:w-full text-left">
                <thead class="divide-y divide-gray-200">
                    <tr>
                        <th class="p-5">Nilai</th>
                        <th class="p-5">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="p-5">{{ '> 25 Orang' }}</td>
                        <td class="p-5">5</td>
                    </tr>
                    <tr>
                        <td class="p-5">21 Orang - 25 Orang</td>
                        <td class="p-5">4</td>
                    </tr>
                    <tr>
                        <td class="p-5">16 Orang - 25 Orang</td>
                        <td class="p-5">3</td>
                    </tr>
                    <tr>
                        <td class="p-5">11 Orang - 15 Orang</td>
                        <td class="p-5">2</td>
                    </tr>
                    <tr>
                        <td class="p-5">{{ '< 10 Orang' }}</td>
                        <td class="p-5">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
        @if ($criteriaName === 'Biaya')
            <table class="table-auto rounded-t-xl overflow-hidden min-w-full w-max md:w-full text-left">
                <thead class="divide-y divide-gray-200">
                    <tr>
                        <th class="p-5">Nilai</th>
                        <th class="p-5">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="p-5">{{ '< 1.000.000' }}</td>
                        <td class="p-5">5</td>
                    </tr>
                    <tr>
                        <td class="p-5">1.000.000 - 1.999.999</td>
                        <td class="p-5">4</td>
                    </tr>
                    <tr>
                        <td class="p-5">2.000.000 - 2.999.999</td>
                        <td class="p-5">3</td>
                    </tr>
                    <tr>
                        <td class="p-5">3.000.000 - 3.999.999</td>
                        <td class="p-5">2</td>
                    </tr>
                    <tr>
                        <td class="p-5">{{ '>= 4.000.000' }}</td>
                        <td class="p-5">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
        @if ($criteriaName === 'Kesulitan')
            <table class="table-auto rounded-t-xl overflow-hidden min-w-full w-max md:w-full text-left">
                <thead class="divide-y divide-gray-200">
                    <tr>
                        <th class="p-5">Nilai</th>
                        <th class="p-5">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="p-5">Sangat Mudah</td>
                        <td class="p-5">5</td>
                    </tr>
                    <tr>
                        <td class="p-5">Mudah</td>
                        <td class="p-5">4</td>
                    </tr>
                    <tr>
                        <td class="p-5">Sedang</td>
                        <td class="p-5">3</td>
                    </tr>
                    <tr>
                        <td class="p-5">Sulit</td>
                        <td class="p-5">2</td>
                    </tr>
                    <tr>
                        <td class="p-5">Sangat Sulit</td>
                        <td class="p-5">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>

<select name="{{ $name }}" id="{{ $id }}"
    class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-navy-night">
    @if ($criteriaName === 'Relevansi')
        <option value="5">Sangat Relevan</option>
        <option value="4">Relevan</option>
        <option value="3">Netral</option>
        <option value="2">Tidak Relevan</option>
        <option value="1">Sangat Tidak Relevan</option>
    @endif
    @if ($criteriaName === 'Dampak Sosial')
        <option value="5">Sangat Tinggi</option>
        <option value="4">Tinggi</option>
        <option value="3">Cukup</option>
        <option value="2">Rendah</option>
        <option value="1">Sangat Rendah</option>
    @endif
    @if ($criteriaName === 'Jumlah Panitia')
        <option value="5">{{ '> 25 Orang' }}</option>
        <option value="4">21 Orang - 25 Orang</option>
        <option value="3">16 Orang - 20 Orang</option>
        <option value="2">11 Orang - 15 Orang</option>
        <option value="1">{{ '< 10 Orang' }}</option>
    @endif
    @if ($criteriaName === 'Biaya')
        <option value="1">{{ '>= 4.000.000' }}</option>
        <option value="2">3.000.000 - 3,999.999</option>
        <option value="3">2.000.000- 2,999.999</option>
        <option value="4">1.000.000- 1,999.999</option>
        <option value="5">{{ '< 1.000.000' }}</option>
    @endif
    @if ($criteriaName === 'Kesulitan')
        <option value="1">Sangat Sulit</option>
        <option value="2">Sulit</option>
        <option value="3">Sedang</option>
        <option value="4">Mudah</option>
        <option value="5">Sangat Mudah</option>
    @endif
</select>
