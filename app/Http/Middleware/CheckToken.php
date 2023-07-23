<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TokenAuth;
use Illuminate\Support\Facades\Log;

class CheckToken
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
        $model = new TokenAuth;

        $all_headers    = $request->header();
        // Log::info($all_headers);

        $today = date('Y-m-d H:i:s');

        if(isset($all_headers['key-mvm'][0])){
            $data = $model->select('id','value_2')
                    ->where('name', 'api key mvm')
                    ->where('value_1', 'key_mvm')
                    ->where('value_2', $all_headers['key-mvm'][0])
                    ->first();

            if(empty($data)){
                Log::error('Unauthorized Access Using Token ' . $all_headers['key-mvm'][0]);

                return response()->json(
                [   'status'       =>  401,
                    'success' => false,
                    'message' => 'Invalid token',
                    'data' => []
                ], 401);
                    
            }
        }
        else{
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Access Forbidden',
                    'data' => []
                ], 401);
        }
        
        return $next($request);
    }
}
