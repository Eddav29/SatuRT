<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Inventaris_Detail extends Model
{
    use HasFactory;

    protected $table = 'inventaris_detail';
    protected $primaryKey = 'inventaris_detail_id';
    protected $keyType = 'String';
    public $incrementing = false;

    public static function boot(){
        parent::boot();
        self::creating(function ($model) {
            $model->inventaris_detail_id = UuidV4::uuid4()->toString();
        });
        
    }

    protected $fillable = [
        'inventaris_id',
        'penduduk_id',
        'jumlah',
        'kondisi',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id', 'inventaris_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }
}
