<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Log In"
        ]);
    }

    public function register()
    {
        return view('auth.register', [
            "title" => "Register Account"
        ]);
    }

    public function registerProses(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|max:255",
            "email" => "required|email:dns|unique:users",
            "password" => "required|confirmed|min:6",
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        $request->session()->flash('success', 'Registrasi Berhasil! Silahkan Login.');
        return redirect('/');
    }

    public function loginProses(Request $request)
    {
        // $rules = ['username' => 'required','password' => 'required'];
        // $validator = validator()->make(request()->all(), $rules);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();
            // dd(auth()->user()->is_admin);
            if (auth()->user()->is_admin == "admin") {
                return redirect()->intended('/dashboard/holding');
                // return redirect()->intended('/holding');
            } else if (auth()->user()->is_admin == "user") {
                return redirect()->intended('/home');
            }
        }

        return back()->with('loginError', 'Login Gagal!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
