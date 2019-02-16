<?php

namespace Tests;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 *
 * @see https://github.com/tymondesigns/jwt-auth/pull/1704
 */
trait JwtAuthentication
{
    /**
     * Overrides the default actingAs() method to set the user token when
     * testing in Laravel.
     *
     * @param Authenticatable $user
     * @param null|string $driver
     *
     * @return $this
     */
    public function actingAs(Authenticatable $user, $driver = null)
    {
        if (method_exists($this, 'withHeader')) {
            $token = JWTAuth::fromUser($user);
            $this->withHeader('Authorization', 'Bearer '.$token);
        }
        return $this;
    }
}
