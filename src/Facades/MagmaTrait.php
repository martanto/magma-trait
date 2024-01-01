<?php

namespace Martanto\MagmaTrait\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Martanto\MagmaTrait\MagmaTrait
 */
class MagmaTrait extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Martanto\MagmaTrait\MagmaTrait::class;
    }
}
