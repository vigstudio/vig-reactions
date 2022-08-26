<?php

use Illuminate\Contracts\Auth\Authenticatable;

if (!function_exists('get_auth_reaction')) {
    /**
     * @return Authenticatable|null
     */
    function get_auth_reaction(): ?Authenticatable
    {
        foreach (array_keys(config('auth.guards')) as $guard) {
            if (auth()->guard($guard)->check()) {
                return auth()->guard($guard)->user();
            }
        }

        return null;
    }
}
