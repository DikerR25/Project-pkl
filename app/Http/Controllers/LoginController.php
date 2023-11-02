<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\RegistrationSuccesful;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('failed', "Invalid Email or Password");
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('succes', 'Logout Succesfully');
    }
    public function register()
    {
        return view('register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        User::create($data);
        $user = User::where('email', $data['email'])->first();
        $admins = User::where('akses', 'admin')->get();
        Notification::send($admins, new RegistrationSuccesful($user));
        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('dashboard')->with('success', "Registrasi akun berhasil");
        } else {
            return redirect()->route('login')->with('failed', "Email atau Password yang anda masukkan salah");
        }
    }
}
