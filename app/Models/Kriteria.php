<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'kriteria_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_kriteria',
        'jenis_kriteria',
        'bobot'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function kriteriaAlternatif()
    {
        return $this->hasMany(KriteriaAlternatif::class, 'kriteria_id', 'kriteria_id');
    }

    public static function getListJenisKriteria()
    {
        return [
            'Cost',
            'Benefit'
        ];
    }
}
