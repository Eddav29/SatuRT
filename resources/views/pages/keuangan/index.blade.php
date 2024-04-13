<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="['Home', 'Keuangan']" :url="['home', 'keuangan']" />
    </x-slot>

    {{-- Content Start --}}
    <!--
  Heads up! 👋

  Plugins:
    
-->
<div class="px-8">         
    <div class="rounded-lg bg-white px-6 py-0">
        <div class="py-6">
            <p class="text-[12px] uppercase tracking-wide font-semibold text-black py-4 px-4 bg-blue-100 text-left">TAMBAH DATA UMKM</p>
        </div>
          <form action="#" class="space-y-4">
           
                <div>
                    <label class="sr-only" for="name"></label>
                    <p class="py-2">Judul</p>
                    <input
                        class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                        placeholder="Judul"
                        type="text"
                        id="judul" name="judul"
                    />
                </div>
                <div>
                  <label class="sr-only" for="name"></label>
                  <p class="py-2">Jenis Keuangan</p>
                  <input
                      class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                      placeholder="Jenis Keuangan"
                      type="text"
                      id="jenis_keuangan" name="jenis_keuangan"
                  />
              </div>
              <div>
                <label class="sr-only" for="name"></label>
                <p class="py-2">Nominal</p>
                <input
                    class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                    placeholder="Nominal"
                    type="number"
                    id="nominal" name="nominal"
                />
            </div>
            <div>
              <label class="sr-only" for="name"></label>
              <p class="py-2">Asal</p>
              <input
                  class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                  placeholder="Status UMKM"
                  type="text"
                  id="status"
              />
          </div>
          <div>
            <label class="sr-only" for="name"></label>
            <p class="py-2">Keterangan</p>
            <input
                class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                placeholder="Status UMKM"
                type="textarea"
                id="status"
            />
        </div>
            <div class="py-14">
              <button
                type="submit"
                class="inline-block w-full rounded-lg bg-blue-500 px-5 py-3 font-medium text-white sm:w-auto"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Content End --}}
</x-app-layout>