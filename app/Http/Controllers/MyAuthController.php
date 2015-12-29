<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;  
use Illuminate\Support\Facades\Input;

class MyAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        if(Sentinel::check())
        {
            return redirect()->route('web.index');
        }
        return view('auth.login');
    }

    public function postLogin()
    {
        $user_name  = Input::get('user_name');
        $userPwd    = Input::get('user_password');
        $remember   = Input::get('user_rememberme');

        $credentials = [
            'email'     =>  $user_name,
            'password'  =>  $userPwd
        ];

        try {
            
            $auth = Sentinel::authenticate($credentials,isset($remember));

            if($auth == true){
                return Response()->json(['success' => true,'message' => '/index']);
            }
            else{
                return Response()->json(['success' => false,'message'=>'Invalid login or password.' ]);
            }
                
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return Response()->json(['success' => false,'message'=>'Account Not Activated.' ]);
        }

    }

    public function getLogout(){
        Sentinel::logout();
        return redirect()->route('auth.login');  
    }
}

?>