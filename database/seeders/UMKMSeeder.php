<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\UMKM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UMKMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->delete(Storage::disk('public')->allFiles());

        $imageMappings = [];
        $data = [
            [
                'penduduk_id' => Penduduk::with('user')->whereHas('user', function ($query) {
                    $query->where('email', 'testpenduduk@example.com');
                })->first()->penduduk_id,
                'nama_umkm' => 'Madura Mart Abah Khairul Non Stop',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Toko Sembako Pemerintah',
                'alamat' => 'Jl. Terusan Piranha Atas No.39, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '082245439067',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('Madura Mart.jpeg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/GZPEPg1LJPGEaM2M8'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Warteg Bintang Rasa',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Warung Tegal',
                'alamat' => 'Jl. Terusan Piranha Atas No.70 A, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '085781468489',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('Warteg bintang rasa.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/8XfVXrt4FEjdBNBu5'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Isi Ulang Air Minum ¨Darma Water¨',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Toko',
                'alamat' => 'Jl. Terusan Piranha Atas No.94, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '087722094868',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('Darma Water.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/hhKge6Ta9uuwxY1Y8'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Komol Kopi',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Cafe dan Resto Kopi Spesial',
                'alamat' => 'Jl. Terusan Piranha Atas No.111B, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('Komol Kopi.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/UBjZ3jqxvXaUnR7a9'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Kost Bu Parno',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Penginapan Kost',
                'alamat' => '3JCM+6MQ, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '085933008828',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('Kost Bu Parno.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/tmAjQXFuwWzmdAa3A'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Cakedbit Premium Cookies',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Toko Roti',
                'alamat' => '3JCP+425, Jl. Ikan Piranha Atas Gg. IVA, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '082301714768',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('cakedbid.jpeg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/NkcAjebQMjs7Bsj98'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Cokelat Klasik Piranha Atas',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Restoran',
                'alamat' => 'Jl. Terusan Ikan Piranha Atas No.18, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('Cokelat klasik.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/qaFVNNL8udv8iycZA'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Presiden Sport',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko Olahraga Luar Ruangan',
                'alamat' => 'Jl. Terusan Piranha Atas No.11, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '0881026849023',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('president sport.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/fvvbXjojiJmsvVBU9'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Service Alat-alat Barbershop',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Layanan Produk Barbershop',
                'alamat' => 'Jl. Terusan Piranha Atas No.30, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '081357365879',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('service alat babershop.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/uLb5b2S75D8KEpo39'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Toko H.S',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko Perlengkapan Rumah',
                'alamat' => '3J9M+XQP, Jl. Ikan Piranha Atas, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('TokoHS.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/vasfK753b9BhE18bA'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Sablon Plastik Satuan',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Toko Sablon Plastik',
                'alamat' => 'Cumi-cumi no.7A. kel. Tunjungsekar kec. Lowokwaru Malang, RT.03 Rw01, Dusun kagrengan, ngijo, Kec. Karang Ploso, Kabupaten Malang, Jawa Timur 65142',
                'nomor_telepon' => '089516186453',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('sablon plastik.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/UNaDDmE5ME4PBCKX6'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Rama Trans Sewa Mobil Malang',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Agen Sewa Mobil',
                'alamat' => 'Jl. Ikan Cumi-Cumi No.4, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '081252910888',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('rama trans.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/7Jvfpc4x7Peff4bj6'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'ZigmaRie Homeset & Fashion',
                'jenis_umkm' => 'Pakaian',
                'keterangan' => 'Toko Pakaian',
                'alamat' => 'Jl. Ikan Cumi-Cumi No.7-A, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '085850873630',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('zigma .jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/RKWW1bGdLJcpvn4Y7'
            ],
            [
                'penduduk_id' => Penduduk::with('user')->whereNotNull('user_id')->get()->random()->penduduk_id,
                'nama_umkm' => 'Toko Puji Jaya',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Minimarket',
                'alamat' => 'Jl. Terusan Ikan Piranha Atas No.60, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
                'nomor_telepon' => '03417729570',
                'status' => 'Aktif',
                'thumbnail_url' => $this->saveImage('TokoPuji.jpg', $imageMappings),
                'lisence_image_url' => $this->saveImage('Lisence.jpg', $imageMappings),
                'lokasi_url' => 'https://maps.app.goo.gl/DJdoqQynRNcYeLpk7'
            ],
        ];

        foreach ($data as $umkm) {
            UMKM::create($umkm);
        }
    }
        /**
     * Save image to public storage and return the URL.
     *
     * @param string $imageName
     * @param array &$imageMappings
     * @return string
     */
    private function saveImage(string $imageName, array &$imageMappings): string
    {
        
        if($imageName == 'Lisence.jpg'){
            $imagePath = public_path("assets/images/{$imageName}");
            $imageContent = file_get_contents($imagePath);
            $hashedName = Str::random(40) . '.jpg';
            Storage::disk('storage_lisence')->put($hashedName, $imageContent);
        }else{
            $imagePath = public_path("assets/images/Usaha/{$imageName}");
            $imageContent = file_get_contents($imagePath);
            $hashedName = Str::random(40) . '.png';
            Storage::disk('public')->put($hashedName, $imageContent);
        }
        
        $imageMappings[$imageName] = $hashedName;
        return $hashedName;
    }
}
