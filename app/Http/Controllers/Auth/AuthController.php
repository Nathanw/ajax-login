<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    // $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        // Validator for login details
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Validate the input and return correct response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        // Attempt to login and return an error messege if the login fails.
        if(!$this->attemptLogin($request)) {
            return response()->json([
                'errors'  => [
                    'invalid' => 'Email or password is incorrect, please try again.'
                ]
            ], 406);
        }

        // Return success to redirect to home screen.
        return response()->json([
            'success'    => true,
            'redirectTo' => '/home'
        ], 200);
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }

}
