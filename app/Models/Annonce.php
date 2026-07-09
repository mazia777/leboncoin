<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['seller_id', 'buyer_id', 'category_id', 'name', 'price', 'description', 'status'])]
class Annonce extends Model
{
    public const STATUS_AVAILABLE = false;

    public const STATUS_SOLD = true;

    protected $table = 'annonces';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the user selling the annonce.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the user who bought the annonce, when it has been sold.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the category attached to the annonce.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images attached to the annonce.
     */
    public function images(): HasMany
    {
        return $this->hasMany(AnnonceImage::class);
    }
}
