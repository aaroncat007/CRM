<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Activation;
use Illuminate\Support\Facades\Input;
use Image;
use Response;
use File;

class HomeController extends Controller
{
    private $user;

    function __construct(){
        $this->middleware('auth');
        $this->user = Sentinel::getUser();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }


    public function ProfileIndex()
    {
        return view('profileIndex',['data' => $this->user]);
    }

    public function profileEdit()
    {
        $uid    = Input::get('uid');
        $pwd    = Input::get('password');
        $repwd  = Input::get('repassword');

        if($pwd != $repwd)
        {
            return back()->withInput()->withErrors('密碼不相符');
        }

        $update = [
            'password' => $pwd
        ];

        //修改密碼
        Sentinel::update($this->user,$update);

        return back()->with('msg','密碼修改成功');
    }


}

?>