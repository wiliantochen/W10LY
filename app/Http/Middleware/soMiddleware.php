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
        // dd($request);
        if (!is_null($request->params['Data'])) {
            $Data = fnDecrypt($request->params['Data']);
            // dd($request->Data);
            foreach ($Data as $key => $row) {
                $request->request->add(array($key => $row));
            }
        }
        // dd($request);
        return $next($request);
    }
}
