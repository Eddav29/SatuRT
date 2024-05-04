<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $primaryKey = 'inventaris_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'penduduk_id',
        'nama_inventaris',
        'merk',
        'warna',
        'jumlah',
        'kondisi',
        'jenis',
        'sumber',
        'keterangan',
        'foto_inventaris'
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

}
