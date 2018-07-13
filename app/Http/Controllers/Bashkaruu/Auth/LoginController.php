<?php

namespace App\Http\Controllers\Bashkaruu\Auth;

use Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\User as User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('bashkaruu.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'login');
        } else {
            $email = $request->input('email');
            $password = $request->input('password');

            if (auth()->attempt(['email' => $email, 'password' => $password])) {
                return redirect()->intended('bashkaruu/');
            } else {
                return redirect()->back()->with('login_failed', trans('auth.failed'));
            }
        }

    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect()->away('login');
    }
}
