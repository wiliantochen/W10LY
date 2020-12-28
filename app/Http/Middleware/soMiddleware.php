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

        if ($request->isMethod('POST')) {
            if (!is_null($request->params['Data'])) {
                $Data = fnDecrypt($request->params['Data']);
                // dd($request->Data);
                foreach ($Data as $key => $row) {
                    $request->request->add(array($key => $row));
                }
            }
        } else {
            if (!is_null($request->Data)) {
                $Data = fnDecrypt($request->Data);
                // dd($request->Data);
                foreach ($Data as $key => $row) {
                    $request->request->add(array($key => $row));
                }
            }            
        }

if (1==0) {
    $date1 = strtotime( $request->AppKey );
    $date2 = strtotime( date('YmdHis') );
    // $date1 = strtotime( '20201228235959' );
    // $date2 = strtotime( '20201229000001' );
    $datediff = $date2 - $date1;
    dd($datediff);
}
        // Begin - Buat Untuk URL yang dikirim tidak bisa copy dan dipakai lagi
        $date1 = strtotime( $request->AppKey );
        $date2 = strtotime( date('YmdHis') );
        $datediff = $date2 - $date1;
        if ($datediff>=60) {
            auth()->invalidate(); // auth()->invalidate(true);  
            return response('Unauthorized.', 401);
        }
        // End - Buat Untuk URL yang dikirim tidak bisa copy dan dipakai lagi

        // dd($request);
        return $next($request);
    }
}
