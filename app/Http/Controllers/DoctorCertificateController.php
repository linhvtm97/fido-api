<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\Http\Resources\MyCollection;
use App\Certificate;
use App\Library\MyFunctions;
use App\Http\Resources\MyResource;

class DoctorCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($doctor_id)
    {
        return new MyCollection(Doctor::find($doctor_id)->certificates()->get());
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
    public function store(Request $request, $doctor_id)
    {
        $certificate = Certificate::create($request->all());
        if ($certificate) {
            if ($image = $request->file('image')) {
                $imageURL = MyFunctions::upload_img($image);
                $certificate->image = $imageURL;
                $certificate->doctor_id = $doctor_id;
                $certificate->save();
            }
            return new MyResource($certificate);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($doctor_id, $id)
    {
        $certificate = Doctor::find($doctor_id)->certificates()->find($id);
        if ($certificate) {
            return new MyResource($certificate);
        }
        return response()->json(['status_code' => 'FAIL'], 401);
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
    public function update(Request $request, $doctor_id, $id)
    {
        $certificate = Doctor::find($doctor_id)->certificates()->find($id);
        if ($certificate) {
            $data = $request->all();
            if ($image = $request->file('image')) {
                $imageURL = MyFunctions::upload_img($image);
                $certificate->image = $imageURL;
                $certificate->save();
            }
            $certificate->update($data);
            return new MyResource($certificate);
        }
        return response()->json(['status_code' => 'FAIL']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($doctor_id, $id)
    {
        $certificate = Doctor::find($doctor_id)->certificates()->find($id);
        if ($certificate) {
            $certificate->delete();
            return response()->json(['status_code' => 'PASS']);
        }
        return response()->json(['status_code' => 'FAIL']);
    }
}
