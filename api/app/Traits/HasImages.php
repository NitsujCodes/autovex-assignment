<?php

namespace App\Traits;

use App\Models\StorageFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin Model
 */
trait HasImages
{
    /** Model Relations */
    public function images() : MorphToMany
    {
       return $this->morphToMany(StorageFile::class, 'imageable',)->withPivot('order')
           ->orderBy('order')
           ->withTimestamps();
    }
    /** End Model Relations */
}
