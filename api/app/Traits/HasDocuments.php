<?php

namespace App\Traits;

use App\Models\StorageFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin Model
 */
trait HasDocuments
{
    /** Model Relations */
    public function documents() : MorphToMany
    {
        return $this->morphToMany(StorageFile::class, 'documentable')->withTimestamps();
    }
    /** End Model Relations */
}
