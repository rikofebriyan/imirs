<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResetPasswordLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            return redirect()->back()->with('error', 'Password not match!');
        }

        $userData = DB::table('sparepartrepair.dbo.users')->get();

        $countUserName = $userData->where('name', '=', $request->name)->count();
        $countUserNPK = $userData->where('NPK', '=', $request->NPK)->count();

        if ($countUserName > 0) return redirect()->back()->with('error', 'Nama sudah dipakai!');
        if ($countUserNPK > 0) return redirect()->back()->with('error', 'NPK sudah dipakai!');

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

    public function resetPassword()
    {
        return view('auth.passwords.email');
    }

    public function sendResetPassword(Request $request)
    {
        $email = $request->email;
        $npk = $request->npk;

        $user = DB::table('sparepartrepair.dbo.users')
            ->where('NPK', '=', $npk)
            ->where('email', '=', $email)
            ->first();

        $token = Str::random(20);

        if ($user == null) {
            return redirect()->back()->with('status', 'User tidak ditemukan.');
        } else {
            $dataSend = [
                'npk' => $user->NPK,
                'name' => $user->name,
                'email' => $user->email,
                'link' => route('recovery-password', 'token=' . $token),
            ];

            Mail::send('emails.resetPassword', $dataSend, function ($message) use ($email) {
                $message->to($email, 'PE-Digitalization')
                    ->subject('I-MIRS reset password link');
                $message->from('pe-digitalization2@outlook.com', 'PE-Digitalization');
            });

            ResetPasswordLink::create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            return redirect()->back()->with('status', 'Link Reset Password Telah Dikirim ke Email');
        }
    }

    public function recoveryPassword(Request $request)
    {
        $token =  DB::table('sparepartrepair.dbo.reset_password_links')->where('token', '=', $request->token)->first();

        if ($token == null) {
            return redirect()->route('login')->with('status', 'Link tidak ditemukan.');
        }

        if ($token->is_use == 1) {
            return redirect()->route('login')->with('status', 'Link tidak dapat digunakan.');
        }

        $user = DB::table('sparepartrepair.dbo.users')
            ->where('id', '=', $token->user_id)
            ->first();

        return view('auth.passwords.reset', [
            'token' => $request->token,
            'npk' => $user->NPK,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function passwordRecovery(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($request->password != $request->password_confirmation) {
            return back()->with('status', 'Password not match!');
        }

        $token =  DB::table('sparepartrepair.dbo.reset_password_links')->where('token', '=', $request->token)->first();
        $user = DB::table('sparepartrepair.dbo.users')
            ->where('id', '=', $token->user_id)
            ->first();

        DB::table('sparepartrepair.dbo.users')->where('id', '=', $user->id)->update([
            'password' => bcrypt($request->password),
        ]);

        DB::table('sparepartrepair.dbo.reset_password_links')->where('token', '=', $request->token)->update(['is_use' => 1]);

        return redirect()->route('login')->with('status', 'Password telah diganti. Silahkan login ulang.');
    }
}
