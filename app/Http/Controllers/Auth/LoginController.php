<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
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
    protected $redirectTo = '/questions';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function getToken(Request $request)
    // {
    //     $request->request->add([
    //       'grant_type' => 'password',
    //       'client_id' => 4,
    //       'client_secret' => 'Z0KeHUZRhrECpVPmGa8aME6ksl8Un34gkMx9kWuu',
    //       'username' => $request->username,
    //       'password' => $request->password
    //     ]);

    //     $requestToken = Request::create(env('APP_URL').'/oauth/token', 'post');
    //     $response = Route::dispatch($requestToken);

    //     return $response;
    // }

}
