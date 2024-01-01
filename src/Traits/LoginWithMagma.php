<?php

namespace Martanto\MagmaTrait\Traits;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait LoginWithMagma
{
    /**
     * Token MAGMA
     */
    protected ?string $tokenUser = null;

    /**
     * URL for MAGMA API
     */
    protected string $magmaApiUrl = 'https://magma.esdm.go.id/api';

    public function httpMagma(): PendingRequest
    {
        return Http::timeout(5)
            ->acceptJson()
            ->baseUrl(config('magma-trait.api_url'));
    }

    /**
     * MAGMA API url
     */
    protected function magmaApiUrl(): string
    {
        if (config()->has('magma-trait.api_url')) {
            return config('magma-trait.api_url');
        }

        return $this->magmaApiUrl;
    }

    /**
     * MAGMA Login API url
     */
    protected function magmaLoginApiUrl(): string
    {
        return $this->magmaApiUrl().'/login';
    }

    /**
     * MAGMA User API url
     */
    protected function magmaUserApiUrl(): string
    {
        return $this->magmaApiUrl().'/v1/user/'.request()->username;
    }

    /**
     * Get the failed getting user information response instance.
     *
     *
     * @throws ValidationException
     */
    protected function sendFailedUserResponse(): Response
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

    /**
     * Get user from MAGMA using token
     *
     *
     * @throws ValidationException
     */
    protected function getUserFromMagma(string $token): array
    {
        $response = $this->httpMagma()->withToken($token)
            ->get($this->magmaUserApiUrl())
            ->json();

        if (array_key_exists('data', $response)) {
            return $response['data'];
        }

        $this->sendFailedUserResponse();
    }

    /**
     * Get or save new user
     */
    protected function updatePassword(array $user)
    {
        return config('magma-trait.model')::updateOrCreate(
            [
                'nip' => $user['nip'],
            ], [
                'password' => request()->password,
                'is_active' => 1,
            ]);
    }

    /**
     *  Login is success or not
     */
    protected function successedLoginMagma(array $response): bool
    {
        Auth::login($this->updatePassword($response['user']));
        $this->tokenUser = $response['token'];

        return true;
    }

    /**
     * Get response after login
     */
    protected function responseLoginMagma(Request $request): mixed
    {
        return $this->httpMagma()->post($this->magmaLoginApiUrl(), [
            'username' => $request->username,
            'password' => $request->password,
        ])->json();
    }

    /**
     * Get MAGMA User token
     */
    protected function tokenUser(Request $request): ?string
    {
        $response = $this->responseLoginMagma($request);

        return $this->tokenUser = $response['success'] ? $response['token'] : null;
    }

    /**
     * Login using MAGMA
     */
    public function attemptLoginMagma(Request $request): bool
    {
        $response = $this->responseLoginMagma($request);

        return $response['success'] && $this->successedLoginMagma($response);
    }
}
