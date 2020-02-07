<?php

namespace App\Http\Middleware;

use Closure;

class AuthJWT {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next) {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'user_not_found'], 404);
            }
            $request->merge(array("authenticated_user_id" => $user->id));
        } catch (TokenExpiredException $e) {
            $token = $request->token;
            $refreshedToken = JWTAuth::refresh($token);
            return response()->json(['message' => "token_expired", "new_token" => $refreshedToken]);
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()]);
        } catch (Exception $exception) {
            return response()->json(['message' => 'token_failure']);
        }
        return $next($request);
    }

}
