<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;



    protected $table = 'status';
    protected $primaryKey = 'status_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'status_id', 'status_id');
    }

}
