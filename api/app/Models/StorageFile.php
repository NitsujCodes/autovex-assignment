<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class StorageFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relative_path',
        'mime_type',
        'size',
        'extension',
        'disk',
    ];

    /** Overrides */
    protected static function booted() : void
    {
        static::creating(function (StorageFile $storageFile) {
            if (!$storageFile->uuid) {
                $storageFile->uuid = Str::uuid()->toString();
            }
        });
    }
    /** End Overrides */

    /** Relations */
    public function imageables(?string $model = null) : MorphToMany
    {
        return $this->morphedByMany(
            $model,
            'imageable',
            'imageables',
            'storage_file_id',
        )->withPivot('order')->withTimestamps();
    }

    public function documentables(?string $model = null) : MorphToMany
    {
        return $this->morphedByMany(
            $model,
            'documentable',
            'documentables',
        )->withTimestamps();
    }
    /** End Relations */

    public function casts() : array
    {
        return [
            'size' => 'integer',
        ];
    }
}
