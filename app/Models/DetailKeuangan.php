<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKeuangan extends Model
{
    use HasFactory;

    protected $table = 'detail_keuangan';
    protected $primaryKey = 'detail_keuangan_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'keuangan_id',
        'judul',
        'jenis_keuangan',
        'asal_keuangan',
        'nominal',
        'keterangan'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'keuangan_id', 'keuangan_id');
    }

    public static function getListJenisKeuangan()
    {
        return [
            'Pemasukan',
            'Pengeluaran'
        ];
    }

    public static function getListAsalKeuangan()
    {
        return [
            'Donasi',
            'Iuran Warga',
            'Kas Umum',
            'Dana Darurat',
            'Lainnya'
        ];
    }
}
