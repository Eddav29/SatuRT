<x-app-layout>
    <x-slot name="breadcrumb">
      <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
  </x-slot>
  
      {{-- Content Start --}}
      <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-action-button :href="'alternatif'" :id="$alternatif->alternatif_id" />
          <div class="rounded-lg bg-white px-6 py-0 overflow-hidden">
            {{-- Information Details --}}
            <section>
              <div class="py-6">
                <p class="text-[20px] uppercase tracking-wide  py-4 px-4 bg-blue-100 text-left rounded-xl font-semibold text-navy-night">DETAIL KEGIATAN</p>
    
            </div>
              <form method="POST" action="{{url('spk')}}" class="space-y-4">
                    <div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                              <label class="sr-only" for="alternatif_id"></label>
                              <p class="py-2 font-semibold text-navy-night">ID Kegiatan</p>
                              <p>{{$alternatif->alternatif_id}}</p>
                            </div>
                            <div>
                              <label class="sr-only" for="nama_alternatif"></label>
                              <p class="py-2 font-semibold text-navy-night">Nama Kegiatan</p>
                              <p>{{$alternatif->nama_alternatif}}</p>
                            </div>
                        </div>          
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 py-8">
                            <div>
                              <label class="sr-only" for="created_at"></label>
                              <p class="py-2 font-semibold text-navy-night">Dibuat Pada</p>
                              <p>{{$alternatif->created_at}}</p>
                            </div>
            
            
                
                            <div>
                              <label class="sr-only" for="updated_at"></label>
                              <p class="py-2 font-semibold text-navy-night">Terakhir Diubah</p>
                              <p>{{$alternatif->updated_at}}</p>
                            </div>
                        </div>    
                    </div>

              </form>
            </section>
            {{-- End Information Details --}}
        </div>
    </div>
      {{-- Content End --}}
  </x-app-layout>
  