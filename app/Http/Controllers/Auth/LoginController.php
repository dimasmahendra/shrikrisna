<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\Storages;
use App\Models\User;
use App\Models\AuthPermission;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = "/";

    public function showLoginForm()
    {
        if (Auth::user()) {   // Check is user logged in
            return redirect()->route('customer.index');
        } else {
            return view('auth.login');
        }
    }

    protected function credentials(Request $request)
    {
        $cred = $request->only($this->email(), 'password');
        $cred['status'] = 1;
        
        return $cred;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where($this->username(), $request->{$this->username()})->first();
        if (empty($user)) {
            $errors = "User Not Found";
        } else if (Hash::check($request->password, $user->password) == false) {
            $errors = "Incorrect Password";
        } else if ($user->status != 1) {
            $errors = "User Not Active";
        } else {
            $errors = trans('auth.failed');
        }
        return redirect('/login')->with("errors", $errors);
    }

    public function email()
    {
        return 'email';
    }

    public function logout(Request $request) {
        $request->session()->flush();
        $this->guard()->logout();
        return redirect('/login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route("customer.index");
    }
}
