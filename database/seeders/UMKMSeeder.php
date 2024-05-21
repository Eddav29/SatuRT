<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\UMKM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UMKMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipPaphReLmXSBWOrWyFt9Y9CckHpPr0mW2R7R--f=w408-h725-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipMEP7PvOXul0TQELs_gi9-CHt8jGcmveY0Wy1W7=w408-h306-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipNdFyn4jmfh4wu9nHY-IuW_27cxhMll1HcyLikJ=w426-h240-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipNHQksH3pC_k1J_6DIjSgEBcYQjhODegz_rSfaK=w408-h544-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipOCDkY8Eq-fMwtxW6kZgJJc-1p6qRthjpc2b5iR=w408-h725-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipOQzxADcGHsUg2qrp3hs8uJ0WF8APZCqBgOfahA=w408-h544-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipN7v41hN6gvJecXiQm_xS1xjLKaIoow-tKbZmTW=w203-h270-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipMYpaehYUbRKVsvWgMRK6GDGVMplZyHiGJq54hh=w408-h544-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipPb4ZYvCxQYE6TSruHEvCjFnaQ5Nbd8T13qtE4b=w408-h544-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh3.googleusercontent.com/gps-proxy/ALd4DhHIJtQ8QDlbMbrpFsD3jxzGrW4_9sM-zB1WuFFHBZ7Joo7gBFFvB57B9fXnTZVZ3DeAaIufhB3Be0Rdl5lMmef7RISAs7psbVVifSVabAQOwrvTCayvJC9nNsKzzkFrD_6tx5hPD653x4x3z6BWcPsvmnxYICVHAuMGVYC7KJ68bVxp7QD9y7LmAD-sslvcDGT-Zug=w408-h306-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipOX4FHZUtyk0UaCZy1xcr5pJ-6Hn1Ww2Z19Z8J5=w408-h306-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipPUv4S6chTh3xSgS4bgGxql1ExoyQQe1UsgCW7i=w408-h544-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh5.googleusercontent.com/p/AF1QipNYALgXIgggPZR3qdGyd2wUEqMLAdP_bTi7xbk3=w203-h114-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
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
                'thumbnail_url' => 'https://lh3.googleusercontent.com/gps-proxy/ALd4DhEp3f44f1ifjqC8DO3ReI8p288__cFCO-MmlGPwOoaXpnqsKkxF0urYBfCb6WkTFhIZtahfQAuamf_PSheqUO2b9arDx6hYezHhiXiOZAcrLp24oWr0G6dmqral55HOy7DIbeJrxW0lJZp8-EpVszsFRtMNO7tjYIjWBrlpxfwcfA1EuO036uAMK9HlLgo2LOVPVkY=w408-h306-k-no',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://maps.app.goo.gl/DJdoqQynRNcYeLpk7'
            ],
        ];

        foreach ($data as $umkm) {
            UMKM::create($umkm);
        }
    }
}
