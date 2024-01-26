<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordManager extends Controller
{
    public function forgetPassword()
    {
        return view("forget-password");
    }
    public function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user',
        ]);
        // THIS IS CAUSING SYNTAX ERROR: UNEXPECTED TOKEN
        // $token = Str::random(length: 64);
        // $token = Str::random(['length' => 64]);
        $token = Str::random(64);

        // INSERT THE EMAIL AND TOKEN TO THE TABLE: password_reset 
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);


        //  SEND AN EMAIL TO THE USERS EMAIL ADDRESS
        // ALSO PASS THE VIEW OF THE EMAIL TEMPLATE FOLDER IN THE emails FOLDER WHICH WILL SERVE AS THE CONTENT OF THE EMAIL
        // ALSO PASS THE TOKEN VALUE TO THE VIEW FOR ACCESS
        // DONT FORGET IN ORDER TO SEND THE EMAIL, YOU HAVE TO CONFIGURE THE SMTP DETAILS IN THE .ENV FOLDER
        // GIVE THE USERNAME AND PASSWORD
        Mail::send(['view' => 'emails.forget-password'], ['token' => $token], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password');
        });


        // THEN RETURN THE USER TO THE FORGET PASSWORD PAGE
        // return back();
        return redirect()->to(route("forget.password"))->with("success", "We have send an email to reset password.");
    }

    function resetPassword($token)
    {
        // THIS IS THE TOKEN BEEN PASSED FROM THE WEB.PHP FROM THE RESETPASSWORD ROUTE AND BEEN PASSED TO THE VIEW
        // ALSO DONT FORGET TO ADD IT TO THE RESETPASSWORD VIEW IN AN INPUT AND MAKE IT HIDDEN
        return view('new-password', compact('token'));
    }
    function resetPasswordPost(Request $request)
    {
        $request->validate([
            "email"=> "required|email|exists:user",
            "password" => "required|string|min:6|confirmed",
            "password_confirm" => "required"
        ]);

        // FETCH THE DATA FROM THE TABLE PASSWORD_RESET IN TH DB
        // CHECK IF THE EMAIL AND TOKEN ARE MATCHING
        $updatePassword = DB::table('password_resets')
            ->where([
                "emeail" => $request->email,
                "token" => $request->token
            ])->first();
        // IF THE DATA IS NOT PRESENT IN THE DB
        if(!$updatePassword) {
            return redirect()->to(route("reset.password"))->with("error", "Invalid");
        }

        // IF THE DATA IS PRESENT THE RESET THEPASSWORD
        User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

        // AFTER RESETING THE PASSWORD WE HAVE TO DELETE THE ROW FROM THE TABLE PASSWORDRESET
        DB::table("password_resets")->where(["email" => $request->email])->delete();

        // NOW RETURN THE USER TO THE LOGIN PAGE AND SHOW A SUCCESS MESSAGE
        return redirect()->to(route("login"))->with("success", "assword Reset Successfully.");
    }
}