<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MyResource;
use Validator;
use App\Library\MyFunctions;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\MyCollection;
use App\Doctor;
use App\User;

class MyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($model)
    {
        return response()->json([
            'status_code' => $model::all() == null ? 304 : 200, 'data' => new MyCollection($model::all())
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, $model, $rule, $message)
    {
        $validator = Validator::make($request->all(), $rule, $message);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json(['status_code' => 202, 'message' => $message]);
        }
        $object = $model::create($request->all());
        if ($object) {
            User::create([
                'user_status' => 'actived',
                'name' => $object->name,
                'email' => $object->email,
                'usable_id' => $object->id,
                'usable_type' => $model,
                'password' => 'default123'
            ]);
            if ($avatar = $request->file('avatar')) {
                $imageURL = MyFunctions::upload_img($avatar);
                $object->avatar = $imageURL;
                $object->save();
            }
            if ($model == 'App\\Doctor') {
                $object = Doctor::with('address', 'specialist', 'sub_specialist', 'employee')->find($object->id);
                $object->doctor_no = 'BS' . random_int(1000, 9999);
                $object->save();
                return response()->json(['status_code' => 201, 'data' => new DoctorResource($object)]);
            }
            return response()->json(['status_code' => 201, 'data' => new MyResource($object)]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($model, $id)
    {
        $object = $model::find($id);
        if ($object) {
            return response()->json(['status_code' => 200, 'data' => new MyResource($object)]);
        }
        return response()->json(['status_code' => 401], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, $id, $model)
    {
        $object = $model::find($id);
        if ($object) {
            $data = $request->all();
            if ($avatar = $request->file('avatar')) {
                $imageURL = MyFunctions::upload_img($avatar);
                $object->avatar = $imageURL;
                $object->save();
            }
            $object->update($data);
            if ($model == 'App\\Doctor') {
                return response()->json(['status_code' => 201, 'data' => new DoctorResource($object)]);
            }
            return response()->json(['status_code' => 201, 'data' => new MyResource($object)]);
        }
        return response()->json(['status_code' => 202]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($id, $model)
    {
        $object = $model::find($id);
        if ($object) {
            $object->delete();
            return response()->json(['status_code' => 204, 'data' => new MyResource($object)]);
        }
        return response()->json(['status_code' => 202, 'data' => new MyResource($object)]);
    }
}
