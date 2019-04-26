<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MyCollection;
use App\Rating;
use App\Doctor;
use App\Library\MyFunctions;
use App\Http\Resources\RatingResource;

class RatingDoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($doctor_id)
    {
        return new MyCollection(Doctor::find($doctor_id)->ratings()->get());
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
        $data = $request->all();
        MyFunctions::updateRating($data['star'], $doctor_id);
        $rating = Rating::create($data);
        if ($rating) {
            $data = Rating::with('patient')->find($rating->id);
            $data->doctor_id = $doctor_id;
            $data->save();
            return response()->json(['status_code' => 200, 'data' => new RatingResource($data)]);
        }
        return response()->json(['status_code' => 302]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($doctor_id, $id)
    {
        $rating = Doctor::find($doctor_id)->ratings()->find($id);

        if ($rating) {
            $data = Rating::with('patient')->find($rating->id);
            return new RatingResource($data);
        }
        return response()->json(['status_code' => 401], 401);
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
        $rating = Rating::with('patient')->find($id);
        if ($rating) {
            $data = $request->all();
            MyFunctions::updateRating($data['star'], $doctor_id);
            $rating->update($data);
            return response()->json(['status_code' => 200, 'data' => new RatingResource($rating)]);
        }
        return response()->json(['status_code' => 302]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($doctor_id, $id)
    {
        $rating = Doctor::find($doctor_id) - ratings()->find($id);
        if ($rating) {
            $rating->delete();
            return response()->json(['status_code' => 204]);
        }
        return response()->json(['status_code' => 202]);
    }
}