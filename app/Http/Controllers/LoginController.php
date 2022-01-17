<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{

    public function index()
    {
        return View('login');
    }

    public function acesso(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where([
            'email' => $request->email,
            'password' => md5($request->password)
        ])->first();



        if ($user) {
            Auth::login($user);
            return redirect('/');
        } else {
            // Go back on error (or do what you want)
            return redirect()->back();
        }
    }

    public function sair()
    {
        Auth::logout();
        return redirect('/');
    }
}
