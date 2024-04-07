<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;


    protected $table = 'alternatif';
    protected $primaryKey = 'alternatif_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_alternatif'
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
        return $this->hasMany(KriteriaAlternatif::class, 'alternatif_id', 'alternatif_id');
    }
}
