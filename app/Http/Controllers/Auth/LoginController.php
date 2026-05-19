<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //Validate the input 
        $credentials = $request->validate([
            'email' => 'required|email',
            'password'=> 'required',
        ]);

        //Attempt to log the user in
        if(Auth::attempt($credentials,$request->boolean('remember'))){
            //Regenrate session for security
            $request->session()->regenrate();

            //Redirect to intended page or home
            return redirect()->intended('/')->with('success','Welcome back!');
        }

        return back()
        ->withErrors(['email'=>'The provided credentials do not match our records.'])
        ->onlyInput('email');

    }
}
