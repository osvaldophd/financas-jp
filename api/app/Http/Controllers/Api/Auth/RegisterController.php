<?php

namespace App\Http\Controllers\Api\Auth;

use JWTAuth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    
    public function __construct() {
        $this->middleware('jwt-auth', ['except' => ['register']]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
        } else {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]);
            return response()->json(array('status' => true, 'token_type' => 'bearer', 'token' => JWTAuth::fromUser($user)), 200);
        }

    }

}
