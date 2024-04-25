<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaAlternatif extends Model
{
    use HasFactory;

    protected $table = 'kriteria_alternatif';
    protected $primaryKey = 'kriteria_alternatif_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'kriteria_id',
        'alternatif_id',
        'nilai'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'kriteria_id');
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id', 'alternatif_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }
}
