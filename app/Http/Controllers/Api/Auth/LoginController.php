<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 4,
            'client_secret' => 'Z0KeHUZRhrECpVPmGa8aME6ksl8Un34gkMx9kWuu',
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $tokenRequest = Request::create(env('APP_URL') . '/oauth/token', 'post');

        $response = Route::dispatch($tokenRequest);

        return $response;
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->noContent();
    }
}
