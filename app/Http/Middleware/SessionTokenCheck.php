<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SessionToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class SessionTokenCheck
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
        $model = new SessionToken;

        $all_headers = $request->header();

        $today = date('Y-m-d H:i:s');

        if(isset($all_headers['session-token'][0])){
            $data = $model->select('id','session_token','username','created_date')
                    ->where('session_token', $all_headers['session-token'][0])
                    ->first();

            if(empty($data))
            {
                return response()->json(
                [   'status'       =>  401,
                    'success' => false,
                    'message' => 'Invalid token',
                    'data' => []
                ], 401);
                    
            }
            else
            {   


                $created_date = Carbon::parse($data['created_date']);
                $now = Carbon::now();
                $diff_in_hours = $now->diffInMinutes($created_date);
                if($diff_in_hours > 30)
                {
                    return response()->json(
                    [
                        'success' => false,
                        'message' => 'your session expired please login again',
                        'data' => []
                    ], 401);
                }
                else
                {
                    try 
                    {
                    $model->where('session_token', $all_headers['session-token'][0])->update( ['created_date' => date("Y-m-d H:i:s")]);
                    } 
                    catch (\Exception $e) 
                    {
                        return response()->json(
                            [   'status'       =>  400,
                                'success'   =>  false,
                                'message'   =>  'Request Failed',
                                'data'      =>  [$e]
                            ], 400);
                    }    
                }


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
