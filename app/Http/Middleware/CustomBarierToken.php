<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Mesin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomBarierToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = null;
        if(isset($_SERVER['Authorization'])){
            $headers = trim($_SERVER["Authorization"]);
            // return $next($request);
        }elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);            
        }elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

            if(isset($requestHeaders['Authorization'])){
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        $barier = preg_match('/Bearer\s(\S+)/', $headers, $matches);
        $mesin = Mesin::where('id_mesin', ($matches) ? $matches[1] : null)->select('id_mesin')->first();
        if($barier && $mesin) {
            return $next($request);
            } else{
                return response()->json([
            'message' => 'Not Authorization',
            'status' => 200
        ]); 
            }        
    }
}
