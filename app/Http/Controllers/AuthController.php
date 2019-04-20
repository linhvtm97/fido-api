<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Library\MyValidation;
use App\User;
use Illuminate\Support\Str;
use App\Http\Resources\MyResource;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth as TymonJWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), MyValidation::$rulesUser, MyValidation::$messageUser);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json($message, 401);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        array_push($data, Str::random(10), 'api_token');
        $user = User::create($data);

        $token = auth()->login($user);

        return $this->respondWithToken($token, $user);
    }

    public static function responseWithUser($user)
    {
        $role = $user->usable;
        if ($role) {
            return new MyResource($role);
        }
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = User::where('email', $request['email'])->first();
        return $this->respondWithToken($token, $user);
      
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'data' => AuthController::responseWithUser($user),
            'group_id' => $user->group_id,
        ]);
    }
}
