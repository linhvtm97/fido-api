<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Library\MyValidation;
use App\User;
use App\Http\Resources\MyCollection;
use Validator;
use App\Http\Resources\MyResource;

class UserController extends Controller 
{
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
            return response()->json([$message, 'status_code' => 'FAIL'], 401);
        }
        $data = $request->all();
        $user = User::create($data);
        $user->password = $data['password'];
   
        $model_name = $user->usable_type;
        $role = $model_name::create($data);    
        $user->usable_id = $role->id;
        $user->save();
        
        if($user){
            return new UserResource($user);
        }
               
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
        $role = $user->usable;
        if ($role) {
            return new MyResource($role);
        }
        return response()->json(['status_code' => 'FAIL']);   
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
        return response()->json(['status_code' => 'FAIL']);   
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
            return response()->json(['status_code' => 'PASS']);   
        }
        return response()->json(['status_code' => 'FAIL']);   
    }
}
