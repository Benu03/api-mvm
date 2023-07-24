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



class MvmController extends Controller
{
    public function home(Request $request)
    {
      
      
        return response()->json(
            [   'status'       =>  200,
                'success'   =>  true,
                'message'   =>  'Request Success',
                'data'      =>  ['mvm']
            ], 200);
        
    
    }
















}
