<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = 'pelaporan';
    protected $primaryKey = 'pelaporan_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'jenis_pelaporan',
        'image_url'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }


    public static function getListJenisPelaporan()
    {
        return [
            'Pengaduan',
            'Kritik',
            'Saran',
            'Lainnya'
        ];
    }
}
