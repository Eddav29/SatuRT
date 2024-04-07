<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persuratan extends Model
{
    use HasFactory;

    protected $table = 'persuratan';
    protected $primaryKey = 'persuratan_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'jenis_surat',
        'nomor_surat',
        'dokumen_url'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    public static function getListJenisSurat()
    {
        return [
            'Surat Keterangan Domisili',
            'Surat Keterangan Tidak Mampu',
            'Surat Keterangan Usaha',
            'Surat Keterangan Lahir',
            'Surat Keterangan Kematian',
            'Surat Keterangan Nikah',
            'Kartu Tanda Penduduk',
        ];
    }
}
