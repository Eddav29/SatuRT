<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class FileStorage extends Model
{
    use HasFactory;

    protected $table = 'file_storage';
    protected $primaryKey = 'file_storage_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penduduk_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->file_storage_id = UuidV4::uuid4()->toString();
        });
    }


    public function files()
    {
        return $this->hasMany(Files::class, 'file_storage_id', 'file_storage_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }
}
