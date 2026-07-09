<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['annonce_id', 'url'])]
class AnnonceImage extends Model
{
    /**
     * Normalize legacy localhost image URLs to the current application host.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): ?string {
                if ($value === null) {
                    return null;
                }

                if (str_starts_with($value, 'http://localhost/storage/')) {
                    return url((string) parse_url($value, PHP_URL_PATH));
                }

                return $value;
            },
        );
    }

    /**
     * Get the annonce attached to this image.
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
