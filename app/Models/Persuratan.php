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
            'Surat Pengantar KTP',
            'Surat Pengantar Kartu keluarga',
            'Surat Pengantar Akta Kelahiran',
            'Surat Pengantar Akta Kematian',
            'Surat Pengantar SKCK',
            'Surat Pengantar Nikah',
            'Lainnya',
        ];
    }

    public function pemohon(): Penduduk
    {
        return Penduduk::find($this->pemohon);
    }
}
