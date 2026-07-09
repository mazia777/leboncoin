<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class Category extends Model
{
    /**
     * Get the annonces attached to this category.
     */
    public function annonces(): HasMany
    {
        return $this->hasMany(Annonce::class);
    }
}
