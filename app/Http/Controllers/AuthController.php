<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Library\MyValidation;
use App\User;
use Illuminate\Support\Str;

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

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
