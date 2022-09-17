<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $headers = [
            'Access-Control-Allow-Origin'      => 'api/*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     =>  "Origin, X-Requested-With, Content-Type, Accept, Authorization"

        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        // Pre-Middleware Action

        $response = $next($request);

        // Post-Middleware Action

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
