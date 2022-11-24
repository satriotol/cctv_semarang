<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ResponseFormatter;
use App\Models\AccessToken;
use Closure;
use Illuminate\Http\Request;

class checkHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessToken = AccessToken::where('token', $request->header('token'))->first();
        if ($accessToken) {
            // if ($accessToken->used >= 25) {
            //     return ResponseFormatter::error($accessToken->used, 'Token Sudah Melebihi Batas');
            // }
            $accessToken->update([
                'used' => $accessToken->used + 1,
            ]);
            return $next($request);
        } else {
            return ResponseFormatter::error($accessToken->used, 'Token Sudah Melebihi Batas');
        }
    }
}