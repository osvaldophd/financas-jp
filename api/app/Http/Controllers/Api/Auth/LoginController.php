<?php

namespace App\Http\Controllers\Api\Auth;

use JWTAuth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('jwt-auth', ['except' => ['login', 'refresh']]);
    }

    /**
     * Handle a login request to the API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {

        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'credencias_invalidas'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'nao_possivel_gerar_token'], 500);
        }
        $status = true;
        $token_type = 'bearer';
        $expires_in = $this->guard()->factory()->getTTL() * 60;
        $usuario = auth()->user();
        // all good so return the token
        return response()->json(compact('status', 'token_type', 'token', 'expires_in', 'usuario'));
        
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $usuario    = User::where('id', auth()->user()->id)->with(['funcionario.contactos','roles'])->first();
        return response()->json($usuario);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (TokenBlacklistedException  $th) {
            return response()->json(['message' => 'token_expired'], 404);
        }

    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
