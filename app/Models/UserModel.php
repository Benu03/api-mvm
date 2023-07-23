<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserModel extends Model
{
 
  protected $connection = 'ts3';


  public static function LoginCheckValidation($data)
  {
    $result = DB::table('auth.v_api_check_user')
              ->where('username',$data['username'])
              ->where('password',sha1($data['password']))
              ->where('is_active',1)
              ->first();
    return $result;   
  }

  public static function LoginCheckUser($data)
  {
    $result = DB::table('auth.v_api_check_user')
              ->where('username',$data['username'])
              ->first();
    return $result;   
  }

  public static function InsertLoginSession($DatainsertSession)
  {
    try 
    {
      $result =  DB::table('auth.user_session_token')->insert($DatainsertSession);
      
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
    return $result;   

  }

  public static function GetUserData($data)
  {
    $result = DB::table('auth.v_api_user_data')
              ->where('username',$data['username'])
              ->first();
    return $result;   
  }

  public static function GetSessionUser($data)
  {    
    $result = DB::table('auth.user_session_token')->selectRaw("session_token,username,created_date")
              ->where('username',$data['username'])->orderby('created_date','Desc')
              ->first();    
    return $result;   
  }

  public static function GetUserClient($data)
  {    
    $result = DB::table('mst.v_user_client')->selectRaw("mst_client_id,client_name,client_type")
              ->where('username',$data['username'])
              ->first();    
    return $result;   
  }

  public static function UpdateLoginUSer($data)
  {    
    $result = DB::table('auth.users')
    ->where('username',$data['username'])
    ->update( [ 
          'is_login' => true
    ]);
    return $result; 
  }


  


  


}
