<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordManager extends Controller
{
    public function forgotPassword()
    {
        return view("auth.password.forgot-password");
    }
    public function forgotPasswordPost(Request $request)
    {
        // cek apakah email ada pengguna ada di database
        $request->validate([
            'email' => "required|email|exists:users"
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        // kirim email berisi link untuk mereset password
        Mail::send("emails.forget-password", ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject("Reset password");
        });
        // kembali ke halaman login jika berhasil
        return redirect()->to(route("login"))->with("success", "We have send an email to reset password");
    }
    // tampilkan view reset password berdasarkan token
    public function resetPassword($token)
    {
        return view("auth.password.reset-password", compact("token"));
    }
    // fungsi mereset password
    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required"
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                "email" => $request->email,
                "token" => $request->token,
            ])->first();
        if (!$updatePassword) {
            return redirect()->to(route("reset.password"))->with("error", "Invalid");
        }
        // masukkan password baru ke database
        User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

        // hapus token
        DB::table("password_reset_tokens")->where(["email" => $request->email])->delete();
        // kembali ke halaman login
        return redirect()->to(route("login"))->with("success", "Reset Password successfully");
    }
}
