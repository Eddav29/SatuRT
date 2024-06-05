<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class UMKM extends Model
{
    use HasFactory;


    protected $table = 'umkm';
    protected $primaryKey = 'umkm_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->umkm_id = UuidV4::uuid4()->toString();
        });
    }

    protected $fillable = [
        'penduduk_id',
        'nama_umkm',
        'jenis_umkm',
        'keterangan',
        'alamat',
        'nomor_telepon',
        'lokasi_url',
        'thumbnail_url',
        'status',
        'lisence_image_url'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }

    public static function getListJenisUMKM()
    {
        return [
            'Makanan dan Minuman',
            'Pakaian',
            'Peralatan',
            'Jasa',
            'Lainnya'
        ];
    }

    public static function getListStatusUMKM()
    {
        return [
            'Aktif',
            'Nonaktif'
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['jenis_umkm'] ?? false, function ($query, $jenis) {
            $query->where('jenis_umkm', $jenis == 'Semua' ? '!=' : '=', $jenis);
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', '=', $status);
        });
    }
}
