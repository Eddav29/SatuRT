<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class KartuKeluarga extends Model
{
    use HasFactory;

    protected $table = 'kartu_keluarga';
    protected $primaryKey = 'kartu_keluarga_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->kartu_keluarga_id = UuidV4::uuid4()->toString();
        });
    }

    protected $fillable = [
        'nomor_kartu_keluarga',
        'nomor_rt',
        'nomor_rw',
        'alamat',
        'desa',
        'kecamatan',
        'kota',
        'kode_pos'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'kartu_keluarga_id', 'kartu_keluarga_id');
    }
}
