<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use Validator;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\MyCollection;
use App\Library\MyValidation;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MyCollection(Doctor::all());
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
        $validator = Validator::make($request->all(), MyValidation::$ruleDoctor, MyValidation::$messageDoctor);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json([$message], 401);    
        }
        $doctor = Doctor::create($request->all());
        if($doctor){
            return new DoctorResource($doctor);
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
        $doctor = Doctor::find($id);
        if ($doctor) {
            return new DoctorResource($doctor);
        }
        return response()->json(['error' => 'ID not found']);   
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
        $doctor = Doctor::find($id);
        if ($doctor) {
            $doctorUpdated = $request->all();
            $doctor->update($doctorUpdated);
            return new DoctorResource($doctor);
        }
        return response()->json(['error' => 'ID not found']);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if ($doctor) {
            $doctor->delete();
            return response()->json(['message' => 'Deleted']);   
        }
        return response()->json(['error' => 'ID not found']);   
    }
}
