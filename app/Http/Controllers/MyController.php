<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MyResource;
use App\Library\MyFunctions;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\MyCollection;
use App\Doctor;
use App\User;
use App\Library\MyValidation;
use DB;
use Validator;
use App\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientCollection;

class MyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($model)
    {
        $results = $model::orderBy('id', 'asc')->get();
        if ($results) {
            if ($model == 'App\\Patient') {
                return response()->json(['status_code' => 200, 'data' => new PatientCollection($results)], 200);
            }
            return response()->json([
                'status_code' => 200, 'data' => new MyCollection($results)
            ], 200);
        }
        return response()->json([
            'status_code' => 204
        ], 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, $model, $rule, $message)
    {
        if (DB::table('users')->where('email', $request['email'])->first()) {
            return response()->json(['status_code' => 202, 'message' => 'Email has already taken'], 202);
        }
        $validator = Validator::make($request->all(), $rule, $message);
        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json(['status_code' => 202, 'message' => $message], 202);
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
                $object->doctor_no = 'BS' . $object->id;
                $object->rating = 3.2;
                $object->save();
                return response()->json(['status_code' => 201, 'data' => new DoctorResource($object)], 201);
            }
            if ($model == 'App\\Employee') {
                $object->employee_no = 'NV' . $object->id;
                $object->save();
                return response()->json(['status_code' => 200, 'data' => new EmployeeResource($object)], 200);
            }
            if ($model == 'App\\Patient') {
                return response()->json(['status_code' => 200, 'data' => new PatientResource($object)], 200);
            }
            return response()->json(['status_code' => 201, 'data' => new MyResource($object)], 201);
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
            if ($model == 'App\\Employee') {
                return response()->json(['status_code' => 200, 'data' => new EmployeeResource($object)], 200);
            }
            return response()->json(['status_code' => 200, 'data' => new MyResource($object)], 200);
        }
        return response()->json(['status_code' => 404, 'message' => 'ID not found'], 404);
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
            $object->update($data);
            if ($avatar = $request->file('avatar')) {
                $imageURL = MyFunctions::upload_img($avatar);
                $object->avatar = $imageURL;
                $object->save();
            }
            if ($model == 'App\\Doctor') {
                return response()->json(['status_code' => 200, 'data' => new DoctorResource($object)], 200);
            }
            if ($model == 'App\\Employee') {
                return response()->json(['status_code' => 200, 'data' => new EmployeeResource($object)], 200);
            }
            if ($model == 'App\\Question') {
                return response()->json(['status_code' => 200, 'data' => new QuestionResource($object)], 200);
            }
            if ($model == 'App\\Patient') {
                return response()->json(['status_code' => 200, 'data' => new PatientResource($object)], 200);
            }
            return response()->json(['status_code' => 200, 'data' => new MyResource($object)], 200);
        }
        return response()->json(['status_code' => 404, 'message' => 'ID not found'], 404);
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
        $user = User::where([
            ['usable_id', '=', $id],
            ['usable_type', '=', $model]
        ])->first();
        if ($object && $user) {
            $object->delete();
            $user->delete();
            return response()->json(['status_code' => 204]);
        }
        return response()->json(['status_code' => 202, 'message' => 'ID not found']);
    }
}
