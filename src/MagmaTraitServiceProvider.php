<?php

namespace Martanto\MagmaTrait;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Martanto\MagmaTrait\Commands\MagmaTraitCommand;

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
            ->hasCommand(MagmaTraitCommand::class);
    }
}
