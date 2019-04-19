<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Library\MyValidation;
use App\User;
use App\Http\Resources\MyCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Str;
use App\Library\MyResponse;
use Illuminate\Contracts\Auth\Authenticatable;

define('ERROR', 1);
define('SUCCESS', 0);

class UserController extends Controller 
{

    public function signUp(Request $request)
    {
        // store($request);

        $validator = Validator::make($request->all(), MyValidation::$rulesUser, MyValidation::$messageUser);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return [new MyResponse(ERROR, $message)];
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        array_push($data, 'api_token', Str::random(10));
        $user = User::create($data);
        if($user){
            return new UserResource($user);
        }
        return [new MyResponse(ERROR, "Serve error - can not register now - come later")];
    }

    public function signIn(Request $request)
    {

        $check = empty($request->email) || empty($request->password);

        if ($check) {
            return [new MyResponse(ERROR, "Email and Password are required")];
        }

        $data = $request->post();
        $user = User::where('email', $data['email'])->first();

        if (empty($user)) {
            return [new MyResponse(ERROR, "User is not found")];
        }

        if (!Hash::check($data['password'], $user->password)) {
            return [new MyResponse(ERROR, "Password is not correct")];
        }

        // code check Remember me 

        return [new MyResponse(SUCCESS, "Sign in successfully", $user)];
    }

    public function signOut(Request $request)
    {
        $user = User::where('id', $request->userID)->first();

        return [new MyResponse(SUCCESS, "Sign out successfully", $user)];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MyCollection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), MyValidation::$rulesUser, MyValidation::$messageUser);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return [new MyResponse(ERROR, $message)];
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        array_push($data, 'api_token', Str::random(10));
        $user = User::create($data);
        if($user){
            return new UserResource($user);
        }
        return [new MyResponse(ERROR, "Serve error - can not register now - come later")];
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return new UserResource($user);
        }

        return "User Not found"; // temporary error
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $userUpdated = $request->all();
            $user->update($userUpdated);
            return new UserResource($user);
        }
        return [new MyResponse(ERROR, "Can not find id")];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return "Deleted";
        }
        return "ID not found";
    }
}
