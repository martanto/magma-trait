<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Support\Str;

trait GenerateSlug
{
    /**
     * Generate Slug
     */
    public static function bootGenerateSlug(): void
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
