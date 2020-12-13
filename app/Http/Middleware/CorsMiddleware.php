<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
           
       //RULE HEADERSNYA HARUS KITA SET SECARA SPESIFIK SEPERTI INI 
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            // 'Access-Control-Allow-Origin'      => 'localhost',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE, WWWWWW',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
            'Authorization'     => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6OTk5OVwvbG9naW4iLCJpYXQiOjE1OTgzNjEzMDMsImV4cCI6MTU5ODM2NDkwMywibmJmIjoxNTk4MzYxMzAzLCJqdGkiOiJObFhIeHZHbEIyQ2ZSVkNHIiwic3ViIjoiQURNSU4iLCJwcnYiOiJhOTgzMmE1ZDhhOTI5NmY5MjY5ZDEyODRlNjlhZDdhNWI4YmMwMjYzIn0.lxF96_xOeqiQXGPO6BtkCz6KBRg7VuY0Hv7XgFnWM78',
        ];
        
        // $headers = [];

        //TAPI JIKA METHOD YANG MASUK ADALAH OPTIONS
        if ($request->isMethod('OPTIONS')) {
            //MAKA KITA KEMBALIKAN BAHWA METHOD TERSEBUT ADALAH OPTIONS
            return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }

        //SELAIN ITU, KITA AKAN MENERUSKAN RESPONSE SEPERTI BIASA DENGAN MENGIKUT SERTAKAN HEADERS YANG SUDAH DITETAPKAN.
        $response = $next($request);
        foreach ($headers as $key => $row) {
            $response->header($key, $row);
        }
        
        return $response;
    }

}

// class CorsMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param \Illuminate\Http\Request $request
//      * @param \Closure                 $next
//      *
//      * @return mixed
//      */
//     public function handle($request, Closure $next)
//     {
//         // TODO: Should check whether route has been registered
//         if ($this->isPreflightRequest($request)) {
//             $response = $this->createEmptyResponse();
//         } else {
//             $response = $next($request);
//         }

//         return $this->addCorsHeaders($request, $response);
//     }

//     /**
//      * Determine if request is a preflight request.
//      *
//      * @param \Illuminate\Http\Request $request
//      *
//      * @return bool
//      */
//     protected function isPreflightRequest($request)
//     {
//         return $request->isMethod('OPTIONS');
//     }

//     /**
//      * Create empty response for preflight request.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     protected function createEmptyResponse()
//     {
//         return new Response(null, 204);
//     }

//     /**
//      * Add CORS headers.
//      *
//      * @param \Illuminate\Http\Request  $request
//      * @param \Illuminate\Http\Response $response
//      */
//     protected function addCorsHeaders($request, $response)
//     {
//         foreach ([
//             'Access-Control-Allow-Origin' => '*',
//             'Access-Control-Max-Age' => (60 * 60 * 24),
//             // 'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
//             'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
//             'Access-Control-Allow-Methods' => $request->header('Access-Control-Request-Methods')
//                 ?: 'GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS',
//             'Access-Control-Allow-Credentials' => 'true',
//         ] as $header => $value) {
//             $response->header($header, $value);
//         }

//         return $response;
//     }
// }
