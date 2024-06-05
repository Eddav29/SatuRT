<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';
    protected $primaryKey = 'keuangan_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'penduduk_id',
        'total_keuangan',
        'tanggal'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal' => 'date'
    ];

    public function detailKeuangan()
    {
        return $this->hasMany(DetailKeuangan::class, 'keuangan_id', 'keuangan_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }
}
