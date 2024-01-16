<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login() {
        // THIS IS TO DEPRIVE THE LOGGED IN USER TO HAVE CCESS TO THE LOGIN AND REGISSTER PAGE AFTER BEEN LOGGED IN
        if(Auth::check()){
            return redirect(route('home'));

        }
        return view('login');
    }


    function register() {
        if(Auth::check()){
            return redirect(route('home'));

        }
        return view('register');
    }


    function loginPost(Request $request) {
//TO CONSOLE ON THE SCREEN THE DATAS COMING
        // $data = $request->all();
    // dd($data);
         $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
         ]);

         //IF REQUEST DATAS ARE NOT PRESENT, ERROR MESSAGE WILL AUTOMATICALLY BE RETURNED
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
            // return redirect()->intended(route('home'))->with("success", "Login successful.");
        }

        return redirect(route('login'))->with("error", "Login details are not valid.");

    }

    function registerPost(Request $request) {
         $request->validate([
            'name' => 'required',
            // 'email' => 'required',
            //TO VALIDATE IF EMAIL IS VALID AND CONTAINS THE NECESSARY CHARACTERS AND UNIQUE FOR EVERY USER
            'email' => 'required|email|unique:user',
            'password' => 'required',
         ]);

         //CREATING A ROW INSIDE THE ROW TO THE TABLE
         $data['name'] = $request->name; //ASIGNING NAME FROM THE REQUEST VARIABLE TO THE DATA NAME VARIABLE
         $data['email'] = $request->email;
         //MAKE SURE YOU ENCRYPT THE PASSWORD WITH THE HASH
         $data['password'] = Hash::make($request->password);
        //  $data['password'] = $request->password;

         $user = User::create( $data );


        $credentials = $request->only('email', 'passwword');
        if(!$user) {
            redirect(route('register'))->with("error", "Registration failed, Try again.");
            // return redirect()->intended(route('home'))->with("success", "Login successful.");
        }

        return redirect(route('login'))->with("success", "Registration successful, Login to access the app.");

    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));

    }
}
