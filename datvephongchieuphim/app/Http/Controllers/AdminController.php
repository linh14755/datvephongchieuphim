<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginAdmin()
    {
        if (auth()->check()) {
            return redirect()->to('/admin/home');
        }
        return view('login');
    }

    public function postloginAdmin(Request $request)
    {
        $remember = $request->has('remember_me') ? true : false;

        if (auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember)) {
            return redirect()->to('/admin/home');
        } else {
            return view('login');
        }
    }


    public function logout()
    {
//        auth()->remember_token->delete();
        auth()->logout();
        return view('login');
    }

    public function registerAdmin()
    {
        return view('register');
    }

    public function postregisterAdmin(Request $request){
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();

        return view('login');
    }
}
