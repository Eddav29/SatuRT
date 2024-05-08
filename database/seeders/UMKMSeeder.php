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
        $penduduk_id = Penduduk::with('user')
            ->whereHas('user', function ($query) {
                $query->where('username', 'testpenduduk');
            })
            ->first()
            ->penduduk_id;

        $data = [
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Warung Mas Dito',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Menyajikan masakan Padang otentik dengan rasa yang lezat dan harga terjangkau.',
                'alamat' => 'Jl. Mangga No. 12A, Jakarta',
                'nomor_telepon' => '081234567890',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Sembako Jaya',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Menyediakan berbagai kebutuhan harian mulai dari bahan makanan hingga kebutuhan rumah tangga lainnya.',
                'alamat' => 'Jl. Mangga No. 12A, Jakarta',
                'nomor_telepon' => '081234567890',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Elektronik Maju',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Menyediakan berbagai produk elektronik terbaru dan berkualitas.',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta',
                'nomor_telepon' => '081234567892',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Mainan Ceria',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Menyediakan berbagai macam mainan untuk anak-anak.',
                'alamat' => 'Jl. Diponegoro No. 20, Bandung',
                'nomor_telepon' => '081234567894',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Warung Buah Segar',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Menyediakan berbagai macam buah segar dan jus buah.',
                'alamat' => 'Jl. Melati No. 5, Surabaya',
                'nomor_telepon' => '081234567891',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Galeri Seni Indah',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Galeri seni yang memamerkan karya seniman lokal.',
                'alamat' => 'Jl. Gajah Mada No. 15, Yogyakarta',
                'nomor_telepon' => '081234567893',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Mainan Ceria',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Menyediakan berbagai macam mainan untuk anak-anak.',
                'alamat' => 'Jl. Diponegoro No. 20, Bandung',
                'nomor_telepon' => '081234567894',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Salon Kecantikan Cantik',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Salon kecantikan yang menyediakan berbagai layanan perawatan kulit.',
                'alamat' => 'Jl. Merdeka No. 25, Semarang',
                'nomor_telepon' => '081234567895',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Kedai Kopi Ceria',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Kedai kopi yang menyediakan kopi berkualitas dari berbagai daerah.',
                'alamat' => 'Jl. Pahlawan No. 30, Surabaya',
                'nomor_telepon' => '081234567896',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Pakaian Trendy',
                'jenis_umkm' => 'Pakaian',
                'keterangan' => 'Toko pakaian dengan koleksi terbaru dan gaya yang trendi.',
                'alamat' => 'Jl. Kencana Indah No. 35, Jakarta',
                'nomor_telepon' => '081234567897',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Bengkel Mobil Terbaik',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Bengkel mobil dengan teknisi terbaik dan harga yang bersaing.',
                'alamat' => 'Jl. Sudirman No. 40, Bandung',
                'nomor_telepon' => '081234567898',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Alat Musik Harmoni',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko alat musik lengkap dengan berbagai macam jenis alat musik.',
                'alamat' => 'Jl. Gajah Mada No. 45, Yogyakarta',
                'nomor_telepon' => '081234567899',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Restoran Seafood Lezat',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Restoran seafood dengan menu lezat dan harga terjangkau.',
                'alamat' => 'Jl. Diponegoro No. 50, Semarang',
                'nomor_telepon' => '0812345678910',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Sepatu Trendy',
                'jenis_umkm' => 'Pakaian',
                'keterangan' => 'Toko sepatu dengan koleksi terbaru dan gaya yang trendi.',
                'alamat' => 'Jl. Merdeka No. 55, Jakarta',
                'nomor_telepon' => '0812345678911',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Klinik Kesehatan Sehat',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Klinik kesehatan dengan layanan yang lengkap dan terjangkau.',
                'alamat' => 'Jl. Sudirman No. 60, Surabaya',
                'nomor_telepon' => '0812345678912',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Perhiasan Mewah',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Toko perhiasan dengan koleksi mewah dan elegan.',
                'alamat' => 'Jl. Gajah Mada No. 75, Yogyakarta',
                'nomor_telepon' => '0812345678913',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Apotek Sehat Berkah',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Apotek yang menyediakan obat-obatan dengan harga terjangkau.',
                'alamat' => 'Jl. Diponegoro No. 80, Semarang',
                'nomor_telepon' => '0812345678914',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Salon Spa Harmoni',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Salon spa dengan layanan perawatan tubuh yang lengkap.',
                'alamat' => 'Jl. Merdeka No. 85, Bandung',
                'nomor_telepon' => '0812345678915',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Sepeda Keren',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko sepeda dengan berbagai jenis sepeda keren dan aksesorisnya.',
                'alamat' => 'Jl. Sudirman No. 90, Jakarta',
                'nomor_telepon' => '0812345678916',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Warung Makan Enak',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Warung makan dengan menu masakan tradisional yang enak.',
                'alamat' => 'Jl. Gajah Mada No. 95, Yogyakarta',
                'nomor_telepon' => '0812345678917',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Gudang Barang Elektronik',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Gudang elektronik dengan harga grosir untuk distributor.',
                'alamat' => 'Jl. Diponegoro No. 100, Semarang',
                'nomor_telepon' => '0812345678918',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Kedai Bunga Indah',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Kedai bunga dengan berbagai macam rangkaian bunga indah.',
                'alamat' => 'Jl. Merdeka No. 105, Bandung',
                'nomor_telepon' => '0812345678919',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Sepatu Olahraga',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko sepatu khusus untuk kebutuhan olahraga.',
                'alamat' => 'Jl. Sudirman No. 110, Jakarta',
                'nomor_telepon' => '0812345678920',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Bengkel Sepeda Motor Andal',
                'jenis_umkm' => 'Jasa',
                'keterangan' => 'Bengkel spesialis perbaikan sepeda motor dengan pelayanan terbaik.',
                'alamat' => 'Jl. Gajah Mada No. 115, Yogyakarta',
                'nomor_telepon' => '0812345678921',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Komputer Terpercaya',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko komputer dengan berbagai macam produk terpercaya dan terjangkau.',
                'alamat' => 'Jl. Sudirman No. 120, Bandung',
                'nomor_telepon' => '0812345678922',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Souvenir Kreatif',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Toko souvenir dengan produk-produk kreatif dan unik.',
                'alamat' => 'Jl. Merdeka No. 125, Jakarta',
                'nomor_telepon' => '0812345678923',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Butik Pakaian Muslimah',
                'jenis_umkm' => 'Pakaian',
                'keterangan' => 'Butik pakaian muslimah dengan desain yang modis dan syar\'i.',
                'alamat' => 'Jl. Diponegoro No. 130, Semarang',
                'nomor_telepon' => '0812345678924',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Perlengkapan Rumah',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko perlengkapan rumah dengan berbagai macam produk lengkap.',
                'alamat' => 'Jl. Gajah Mada No. 135, Yogyakarta',
                'nomor_telepon' => '0812345678925',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Galeri Seni Abstrak',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Galeri seni yang memamerkan karya seniman abstrak terkini.',
                'alamat' => 'Jl. Sudirman No. 140, Bandung',
                'nomor_telepon' => '0812345678926',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Kedai Roti Lezat',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Kedai roti dengan berbagai macam roti lezat dan fresh.',
                'alamat' => 'Jl. Merdeka No. 145, Jakarta',
                'nomor_telepon' => '0812345678927',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Buku Edukatif',
                'jenis_umkm' => 'Peralatan',
                'keterangan' => 'Toko buku dengan berbagai macam buku edukatif dan bermanfaat.',
                'alamat' => 'Jl. Diponegoro No. 150, Semarang',
                'nomor_telepon' => '0812345678928',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Kedai Minuman Segar',
                'jenis_umkm' => 'Makanan dan Minuman',
                'keterangan' => 'Kedai minuman dengan berbagai macam minuman segar dan menyegarkan.',
                'alamat' => 'Jl. Gajah Mada No. 155, Yogyakarta',
                'nomor_telepon' => '0812345678929',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
            [
                'penduduk_id' => $penduduk_id,
                'nama_umkm' => 'Toko Kacamata Fashion',
                'jenis_umkm' => 'Lainnya',
                'keterangan' => 'Toko kacamata dengan berbagai macam model dan desain fashion.',
                'alamat' => 'Jl. Sudirman No. 160, Bandung',
                'nomor_telepon' => '0812345678930',
                'status' => 'Aktif',
                'thumbnail_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lisence_image_url' => '1714997937.elina-emurlaeva-mAWWkKnxf6g-unsplash.jpg',
                'lokasi_url' => 'https://goo.gl/maps/5TJHt4kW3Rq2'
            ],
        ];

        foreach ($data as $umkm) {
            UMKM::create($umkm);
        }
    }
}
