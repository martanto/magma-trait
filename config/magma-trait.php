<?php

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
