<?php

namespace App\Http\Controllers;

use \Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check())
        {
            return back();
        }
        else
        {
            // $user =DB::table('users')->update(array('systemstatus'=> 0));
            $request->session()->forget('passworduser_id');
            $request->session()->forget('passwordtime');
            Auth::logout();
            return view('login');
        }
    }
    public function logout()
    {
        if(Auth::check())
        {
            $user = Auth::user()->id;
            $user = User::find($user);
            $user->systemstatus = 0;
            $user->update();
            Session::flush();
            Auth::logout();
            return redirect()->route('admin.login');
        }
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $response = [
            'status' => 0,
            'message' => 'Email or Password in invalid!',
        ];
        if($validate->fails())
        {
            $response = [
                'status' => 2,
                'message' => $validate->messages(),
            ];
        }
        else
        {
            $data = [
                'email' => $email,
                'password' => $password
            ];
            if(Auth::attempt($data))
            {
                $user = Auth::user()->id;
                $user = User::find($user);
                $user->systemstatus = 1;
                $user->update();
                $response = [
                    'status' => 1,
                    'message' => 'You have successfully logged in!',
                ];
            }
        }
        return response()->json($response);
    }
}
