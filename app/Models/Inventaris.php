<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $primaryKey = 'inventaris_id';
    protected $keyType = 'int';
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->inventaris_id = UuidV4::uuid4()->toString();
        });
    }

    protected $fillable = [
        'penduduk_id',
        'nama_inventaris',
        'merk',
        'warna',
        'jumlah',
        'jenis',
        'sumber',
        'keterangan',
        'foto_inventaris',
    ];

    public static function getListJenis()
    {
        return [
            'Furnitur', 'Elektronik', 'ATK', 'Kendaraan', 'Perlengkapan', 'Lainnya',
        ];
    }

    public static function getListSumber()
    {
        return [
            'Hibah', 'Beli', 'Donasi', 'Bantuan', 'Pinjaman',
        ];
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }

}
