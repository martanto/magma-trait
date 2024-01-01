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
     *
     * @var string|null
     */
    protected ?string $tokenUser = null;

    /**
     * URL for MAGMA API
     *
     * @var string
     */
    protected string $magmaApiUrl = 'https://magma.esdm.go.id/api';

    /**
     * @return PendingRequest
     */
    public function httpMagma(): PendingRequest
    {
        return Http::timeout(5)
            ->acceptJson()
            ->baseUrl(config('magma-trait.api_url'));
    }

    /**
     * MAGMA API url
     *
     * @return string
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
     *
     * @return string
     */
    protected function magmaLoginApiUrl(): string
    {
        return $this->magmaApiUrl().'/login';
    }

    /**
     * MAGMA User API url
     *
     * @return string
     */
    protected function magmaUserApiUrl(): string
    {
        return $this->magmaApiUrl() . '/v1/user/' . request()->username;
    }

    /**
     * Get the failed getting user information response instance.
     *
     * @return Response
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
     * @param string $token
     * @return array
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
            ],[
                'password' => request()->password,
                'is_active' => 1,
            ]);
    }

    /**
     *  Login is success or not
     *
     * @param array $response
     * @return boolean
     */
    protected function successedLoginMagma(array $response): bool
    {
        Auth::login($this->updatePassword($response['user']));
        $this->tokenUser = $response['token'];

        return true;
    }

    /**
     * Get response after login
     *
     * @param Request $request
     * @return mixed
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
     *
     * @param Request $request
     * @return string|null
     */
    protected function tokenUser(Request $request): ?string
    {
        $response = $this->responseLoginMagma($request);

        return $this->tokenUser = $response['success'] ? $response['token'] : null;
    }

    /**
     * Login using MAGMA
     *
     * @param Request $request
     * @return boolean
     */
    public function attemptLoginMagma(Request $request): bool
    {
        $response = $this->responseLoginMagma($request);

        return $response['success'] && $this->successedLoginMagma($response);
    }
}
