<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated( $request, $user)
    {
        toast( $user->name . ' خوش آمدید! ','success')->width('300')->position('center');

        if($user->role === 'admin') {
            return redirect()->intended('/admin/index');
            exit;
        }
        if(!$user->role){
            return redirect()->intended('/users/profile');
            exit;
        }

//    path_for_normal_user
        return redirect()->intended('/');
    }



    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
//            'g-recaptcha-response' => 'required|captcha'
        ]);
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }



//        if(auth()->validate($request->only('email' , 'password'))) {
//            $user = User::whereEmail($request->input('email'))->first();
//            if($user->active == 0 ) {
//                $checkActiveCode = $user->activationCode()->where('expire' , '>=' , time() )->latest('id')->first();
//                if ($checkActiveCode)
//                    $checkActiveCode = $checkActiveCode->toArray();
//
//                if(is_array($checkActiveCode) && count($checkActiveCode)) {
//                    if($checkActiveCode['expire'] > time() ) {
//                        $this->incrementLoginAttempts($request);
//                        return back()->withErrors(['code' => 'ایمیل فعال سازی قبلا به ایمیل شما ارسال شده است. در صورتی که inbox خود ایمیل ما را نیافتید پوشه spam را هم برسی کنید.']);
//                    }
//                } else {
//                    event(new UserActivation($user));
//                }
//            }
//        }



        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
