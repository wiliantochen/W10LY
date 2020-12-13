<?php

namespace App\Http\Middleware;

use Closure;

class soMiddleware
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
        // dd('masuk sini soMiddleware');
        if (!is_null($request->data)) {
            $Data = fnDecrypt($request->data);
            // dd($request->data);
            foreach ($Data as $key => $row) {
                $request->request->add(array($key => $row));
            }
        }
        // dd($response);

        return $next($request);
    }
}
