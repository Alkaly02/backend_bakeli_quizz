<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api', [
            'except' => [
                'login',
                'register',
                'logout',
                'getUser',
                "refreshToken",
            ]
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if ($token) {
            return $this->responseWithToken($token);
        }

        return response()->json(['status' => 'failed', 'message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 1,
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function getUser()
    {
        return response()->json(auth()->user(), Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(["message" => "User logged out successfully"], Response::HTTP_OK);
    }

    public function refreshToken()
    {
        return $this->responseWithToken(auth()->refresh());
    }

    protected function responseWithToken($token)
    {
        return response()->json(['access_token' => $token, "token_type" => 'Bearer', 'expire_in' => 60], Response::HTTP_OK);
        // return response()->json(['access_token' => $token, "token_type" => 'Bearer', 'expire_in' => 3600], Response::HTTP_OK);
    }
}
