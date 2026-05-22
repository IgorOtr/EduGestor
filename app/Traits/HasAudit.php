<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasAudit
{
    public function getCreatedByAttribute(): ?string
    {
        return $this->attributes['created_by'] ?? null;
    }

    public static function bootHasAudit(): void
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });
    }
}
