<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';
    protected $primaryKey = 'penduduk_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->penduduk_id = UuidV4::uuid4()->toString();
        });
    }

    protected $fillable = [
        'kartu_keluarga_id',
        'user_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'pekerjaan',
        'golongan_darah',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'status_hubungan_dalam_keluarga',
        'status_perkawinan',
        'pendidikan_terakhir',
        'foto_ktp',
        'status_penduduk',
        'nomor_rt',
        'nomor_rw',
        'desa',
        'kecamatan',
        'kota',
        'status_kehidupan'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_lahir' => 'date'
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id', 'kartu_keluarga_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function umkm()
    {
        return $this->hasMany(UMKM::class, 'penduduk_id', 'penduduk_id');
    }

    public function informasi()
    {
        return $this->hasMany(Informasi::class, 'penduduk_id', 'penduduk_id');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'penduduk_id', 'penduduk_id');
    }

    public static function getListGolonganDarah()
    {
        return ['A', 'B', 'AB', 'O'];
    }

    public static function getListAgama()
    {
        return ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
    }

    public static function getListStatusHubunganDalamKeluarga()
    {
        return ['Kepala Keluarga', 'Istri', 'Anak', 'Cucu', 'Ayah', 'Ibu', 'Saudara', 'Mertua', 'Menantu', 'Cucu Menantu', 'Cicit', 'Keluarga Lain'];
    }

    public static function getListStatusPerkawinan()
    {
        return ['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'];
    }

    public static function getListPendidikanTerakhir()
    {
        return ['Tidak Sekolah', 'TK', 'SD', 'SMP', 'SMA', 'SMK', 'MA',  'D3', 'S1', 'S2', 'S3'];
    }

    public static function getListStatusPenduduk()
    {
        return ['Domisili', 'Non Domisili'];
    }

    public static function getListJenisKelamin()
    {
        return ['Laki-laki', 'Perempuan'];
    }

    public static function getListStatusKehidupan()
    {
        return ['Hidup', 'Meninggal'];
    }

}
