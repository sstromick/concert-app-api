<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;

class ApiToken {
    public function handle($request, Closure $next) {
        $api_keys = ApiKey::where('active', 1)->pluck('api_key');
        $user = $request->getUser();

        if (!$api_keys->contains($user)) {
            return $this->plainJson(__('auth.failed'), null, 401);
        }

        return $next($request);
    }
}
