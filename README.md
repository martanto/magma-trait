# Trait and service generator for MAGMA Indonesia app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/martanto/magma-trait.svg?style=flat-square)](https://packagist.org/packages/martanto/magma-trait)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/martanto/magma-trait/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/martanto/magma-trait/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/martanto/magma-trait/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/martanto/magma-trait/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/martanto/magma-trait.svg?style=flat-square)](https://packagist.org/packages/martanto/magma-trait)

This package is used to generate trait and service for MAGMA Indonesia

## Installation

You can install the package via composer:

```bash
composer require martanto/magma-trait
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="magma-trait-config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    */
    'model' => config('auth.providers.users.model'),

    /*
    |--------------------------------------------------------------------------
    | MAGMA API url
    |--------------------------------------------------------------------------
    |
    | This one define where the MAGMA API url located
    |
    */
    'api_url' => 'https://magma.esdm.go.id/api',
];
```

## Usage

```php
use AuthenticatesUsers;
use ByteConverter;
use ColorPalettesTrait;
use GenerateSlug;
use GenerateUUID;
use JsonFromFileTrait;
use LoginWithMagma;
use ThrottlesLogins;
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Martanto](https://github.com/martanto)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
