<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        if (Auth::attempt(['NPK' => $request->NPK, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->with([
            'loginError' => 'Login Failed!'
        ])->onlyInput('loginError');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function submitRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'NPK' => 'required',
            'jabatan' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($request->password != $request->password_confirmation) {
            return back()->with('error', 'Password not match!');
        }

        $validatedData = [
            'name' => $request->name,
            'NPK' => $request->NPK,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        User::create($validatedData);
        return redirect()->back()->with('success', 'User Registered!');
    }
}
