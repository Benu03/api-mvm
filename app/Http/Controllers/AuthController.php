<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Libraries\Helpers;
use App\Models\UserModel;


class AuthController extends Controller
{
    public function login(Request $request)
    {
      
        log::info('Begin login User '.$request->username);

        if(isset($request['username']) && isset($request['password'])){

            $data = [ 'username' => $request->username , 'password' => $request->password ];
            $loginCheckUser = UserModel::LoginCheckUser($data);
                if(isset($loginCheckUser))
                {

                    $LoginCheckValidation = UserModel::LoginCheckValidation($data);
                    if(isset($LoginCheckValidation))
                    {


                        $DatainsertSession = [
                            'session_token' => sha1(Str::random(40)),
                            'username' => $request->username
                        ];

                        $loginSession = UserModel::InsertLoginSession($DatainsertSession);

                        $UpdateLogin = UserModel::UpdateLoginUSer($data);

                        log::info('End login User '.$request->username);

                        return response()->json(
                            [   'status'    =>  200,
                                'success'   =>  true,
                                'message'   =>  'success',
                                'data'      => [
                                                'session' => UserModel::GetSessionUser($data) ,
                                                'user' => UserModel::GetUserData($data),
                                                'type' =>   UserModel::GetUserClient($data)                          
                                              ]
                            ], 200);
                        
                    }
                    else
                    {

                        log::info('End login User '.$request->username);
                        return response()->json(
                            [   'status'    =>  200,
                                'success'   =>  true,
                                'message'   =>  'Your Password Not Valid',
                                'data'      =>  []
                            ], 200);

                    }

                    
                
        
        
                }
                else
                {
                    log::info('End login User '.$request->username);
                    return response()->json(
                        [   'status'    =>  200,
                            'success'   =>  true,
                            'message'   =>  'success',
                            'data'      =>  'User '.$request->username.' Not Avaliable'
                        ], 200);
        
                }

        }
        else
        {
            log::info('End login User');
            return response()->json(
                [   'status'    =>  400,
                    'success'   =>  false,
                    'message'   =>  'Your Request Not Match',
                    'data'      =>  []
                ], 401);

        }
        
    
    }
















}
