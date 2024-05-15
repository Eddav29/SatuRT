<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Files extends Model
{
    use HasFactory;

    // Schema::create('files', function (Blueprint $table) {
    //     $table->uuid('file_id')->primary();
    //     $table->uuid('file_storage_id')->index();
    //     $table->string('file_name');
    //     $table->string('file_extension');
    //     $table->string('file_type');
    //     $table->string('file_size');
    //     $table->string('file_url');
    //     $table->string('disk_name')->nullable();
    //     $table->timestamps();
    //     $table->foreign('file_storage_id')->references('file_storage_id')->on('file_storages');
    // });

    protected $table = 'files';
    protected $primaryKey = 'file_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'file_storage_id',
        'file_name',
        'file_extension',
        'file_type',
        'file_size',
        'file_url',
        'disk_name'
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
            $model->file_id = UuidV4::uuid4()->toString();
        });
    }

    public function fileStorage()
    {
        return $this->belongsTo(FileStorage::class, 'file_storage_id', 'file_storage_id');
    }
}
