<?php

namespace Martanto\MagmaTrait;

use Martanto\MagmaTrait\Commands\MakeService;
use Martanto\MagmaTrait\Commands\MakeTrait;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MagmaTraitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('magma-trait')
            ->hasConfigFile('magma-trait')
            ->hasCommands([
                MakeTrait::class,
                MakeService::class,
            ]);
    }
}
