<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Informasi extends Model
{
    use HasFactory;

    protected $table = 'informasi';
    protected $primaryKey = 'informasi_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->informasi_id = UuidV4::uuid4()->toString();
        });
    }

    protected $fillable = [
        'penduduk_id',
        'judul_informasi',
        'jenis_informasi',
        'isi_informasi',
        'thumbnail_url',
        'excerpt'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }

    public static function getListJenisInformasi()
    {
        return [
            'Pengumuman',
            'Dokumentasi Kegiatan',
            'Dokumentasi Rapat',
            'Berita',
            'Artikel',
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('judul_informasi', 'like', '%' . $search . '%');
        });

        $query->when($filters['jfsi'] ?? false, function ($query, $jfsi) {
            $query->where('jenis_informasi', '!=', 'Pengumuman')
                ->where('jenis_informasi', $jfsi == 'Semua' ? '!=' : '=', $jfsi);
        });
    }
}
