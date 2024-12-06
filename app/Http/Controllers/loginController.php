<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Auth;

use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class loginController extends Controller
{
    // this method will show login page for user
    public function index()
    {
        return view("login");
    }
    // this methos will authenticate user
    public function authenticate(Request $request)
    {
        // Validate user input
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors
            return redirect()->route('account.login')->withErrors($validator)->withInput();
        }

        // Attempt to authenticate the user
        if (
            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            // Redirect to dashboard or intended page
            return redirect()->route('dashboard'); // Update 'dashboard' to your intended route name
        } else {
            // Authentication failed
            return redirect()->route('account.login')->with('error', 'Either email or password is incorrect');
        }
    }
    // this method will show register page
    public function register()
    {

        return view('register');
    }
    public function processregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->save();
            return redirect()->route('account.login')->with('success', 'You Registerd');
        } else {
            return redirect()->route('account.register')->withErrors($validator)->withInput();
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
