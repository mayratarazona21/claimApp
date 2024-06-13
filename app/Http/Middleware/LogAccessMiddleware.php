<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;

class LogAccessMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    $user = auth()->user();
    $ip = $request->ip();
    $url = $request->fullUrl();
    $method = $request->method();

    if (isset($user)) {
      Log::create([
        'user_id' => $user->id,
        'action' => 'access',
        'details' => json_encode([
          'ip' => $ip,
          'url' => $url,
          'method' => $method,
        ]),
      ]);
    }

    return $next($request);
  }
}
