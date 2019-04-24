<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MyResource;
use App\Http\Resources\MyCollection;
use Validator;
use App\Library\MyFunctions;
use App\Http\Resources\DoctorResource;

class MyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($model)
    {
        return new MyCollection($model::paginate(10));
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
            return response()->json([$message], 401);
        }
        $object = $model::create($request->all());
        if ($object) {
            if ($avatar = $request->file('avatar')) {
                $imageURL = MyFunctions::upload_img($avatar);
                $object->avatar = $imageURL;
                $object->save();
            }
            if ($model == 'App\\Doctor') {
                    return new DoctorResource($object);
                }
            return new MyResource($object);
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
            return new MyResource($object);
        }
        return response()->json(['status_code' => 'FAIL'], 401);
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
                    return new DoctorResource($object);
                }
            return new MyResource($object);
        }
        return response()->json(['status_code' => 'FAIL']);
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
            return response()->json(['status_code' => 'PASS']);
        }
        return response()->json(['status_code' => 'FAIL']);
    }
}
