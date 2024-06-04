<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Hashids;

class EncryptIds
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Encriptar el ID entrante (si existe)
    if ($request->id) {
      $request->merge(['id' => Hashids::encode($request->id)]);
    }

    // Desencriptar el ID saliente (si existe)
    $response = $next($request);

    if ($response->original && isset($response->original['id'])) {
      $response->original['id'] = Hashids::decode($response->original['id'])[0];
    }

    return $response;
  }
}
