<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Support\Str;

trait GenerateUUID
{
    /**
     * Generate UUID
     */
    public static function bootGenerateUUID(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
