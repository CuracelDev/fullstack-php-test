<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ManagesResponse;
use Closure;
use Illuminate\Http\Request;

class Curacel
{
    use ManagesResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('id', $request->bearerToken())->first();
        if (!$user) {
            return $this->sendErrors('Unauthenticated', 401)->setStatusCode(401);
        }

        $request->merge(['user' => $user]);
        return $next($request);
    }
}
