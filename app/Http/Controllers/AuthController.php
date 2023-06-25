<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaftarRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function tampilanLogin()
    {
        return view('auth.login');
    }

    public function Login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // if ($credentials->fails()) {
        //     return redirect('/login')
        //         ->withErrors($credentials)
        //         ->withInput();
        // }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            //jika user
            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'email' => 'Email tidak sesuai',
                'password' => 'password tidak sesuai',
            ]);
        }
    }

    public function tampilandaftar()
    {
        return view('auth.daftar');
    }

    public function daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'email.unique' => 'Email sudah pernah digunakan',
            'password.confirmed' => 'Password konfirmasi tidak sama.'
        ]);

        // if ($validator->fails()) {
        //     return Redirect()->back()->with('erorr', 'Register gagal. Silahkan coba lagi');
        // }

        if ($validator->fails()) {
            return redirect('/daftar')
                ->withErrors($validator)
                ->withInput();
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


        return view('auth.login')->with('success', 'Register Berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgetPasswords');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed|min:6'
        ], [

            'password.confirmed' => 'Password konfirmasi tidak sama.'
        ]);
        // dd($request->username);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'The provided username does not exist.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Your password has been reset.');
    }

    protected function broker()
    {
        return Password::broker();
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
}
