<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User as User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

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
        return view('admin.auth.login');
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
                Log::info('Пользователь '.$email.' вошел в систему.');
                return redirect()->intended('/admin');
            } else {
                Log::alert('Пользователь '.$email.' пытался авторизоваться, но безуспешно.');
                return redirect()->back()->with('login_failed', trans('auth.failed'));
            }
        }

    }

    public function logout(Request $request) 
    {
        $user = auth()->user();
        Auth::logout();
        Log::info('Пользователь '.$user->email.' вышел из системы.');
        return redirect()->away('login');
    }
}
