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
        // dd('masuk sini CorsMiddleware');
           
       //RULE HEADERSNYA HARUS KITA SET SECARA SPESIFIK SEPERTI INI 
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            // 'Access-Control-Allow-Origin'      => 'localhost',
            // 'Access-Control-Allow-Origin'      => 'http://localhost:8081',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE, lumen',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Accept, Authorization, X-Requested-With, Origin',
            'Authorization'     => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6OTk5OVwvbG9naW4iLCJpYXQiOjE1OTgzNjEzMDMsImV4cCI6MTU5ODM2NDkwMywibmJmIjoxNTk4MzYxMzAzLCJqdGkiOiJObFhIeHZHbEIyQ2ZSVkNHIiwic3ViIjoiQURNSU4iLCJwcnYiOiJhOTgzMmE1ZDhhOTI5NmY5MjY5ZDEyODRlNjlhZDdhNWI4YmMwMjYzIn0.lxF96_xOeqiQXGPO6BtkCz6KBRg7VuY0Hv7XgFnWM78',
        ];

        // $headers = [
        //     'Access-Control-Allow-Origin'      => '*',
        //     'Access-Control-Allow-Methods'     => '*',
        //     'Access-Control-Allow-Credentials' => 'true',
        //     'Access-Control-Max-Age'           => '0',
        //     'Access-Control-Allow-Headers'     => '*',
        // ];

        // $headers = [];

        //TAPI JIKA METHOD YANG MASUK ADALAH OPTIONS
        if ($request->isMethod('OPTIONS')) {
            //MAKA KITA KEMBALIKAN BAHWA METHOD TERSEBUT ADALAH OPTIONS
            return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }

        //SELAIN ITU, KITA AKAN MENERUSKAN RESPONSE SEPERTI BIASA DENGAN MENGIKUT SERTAKAN HEADERS YANG SUDAH DITETAPKAN.
        $response = $next($request);

        if(!method_exists($response, 'header')) {
            $response->headers->set('Access-Control-Allow-Origin' , '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        } else {
            foreach ($headers as $key => $row) {
                $response->header($key, $row);
            }
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
