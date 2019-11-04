<?php

namespace App\Http\Middleware;

use Closure;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * ESTE (y cualquier) MIDDLEWARE HAY QUE REGISTRARLO EN Kernel.php
     * Los MIDDLEWARE se usan para realizar validaciones y filtrados de las rutas y sus parámetros de forma más genérica que en los controladores, sobretodo a nivel HTTP
     */

    // lo estamos utilizando en la ruta /other/{age} controlada por el controlador TestController
    public function handle($request, Closure $next) {
        if ($request->age <= 200) {
            return redirect('/');
        }
        return $next($request);
    }

    // esto se ejecutará cuando el cliente reciba la respuesta, por eso el 2º parámetro es $response
    public function terminate($request, $response)
    {
        // Store the session data...
    }
}
