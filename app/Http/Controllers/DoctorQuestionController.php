<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\QuestionCollection;
use App\Doctor;
use App\Library\MyValidation;
use Validator;
use App\Question;
use App\Library\MyFunctions;
use App\Http\Resources\QuestionResource;
use App\Patient;

class DoctorQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        if ($doctor) {
            return new QuestionCollection($doctor->questions()->orderBy('id', 'desc')->get());
        }
        return response()->json(['status_code' => 401, 'message' => 'ID not found'], 401);
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
        $validator = Validator::make($request->all(), MyValidation::$ruleQuestion, MyValidation::$messageQuestion);
        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json(['status_code' => 202, 'message' => $message]);
        }
        if (!$doctor = Doctor::find($doctor_id)) {
            return response()->json(['status_code' => 404, 'message' => 'ID doctor not found']);
        }
        if (!$patient = Patient::find($request->patient_id)) {
            return response()->json(['status_code' => 404, 'message' => 'ID patient not found']);
        }
        $question = Question::create($data);
        if ($question) {
            return response()->json(['status_code' => 200, 'data' => new QuestionResource($question)]);
        }
        return response()->json(['status_code' => 302, 'message' => 'Can not create']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($doctor_id, $id)
    {
        $question = Doctor::find($doctor_id)->questions()->find($id);

        if ($question) {
            return new QuestionResource($question);
        }
        return response()->json(['status_code' => 401, 'message' => 'ID not found'], 401);
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
        if (!$doctor = Doctor::find($doctor_id)) {
            return response()->json(['status_code' => 404, 'message' => 'ID doctor not found']);
        }
        if (!$patient = Patient::find($request->patient_id)) {
            return response()->json(['status_code' => 404, 'message' => 'ID patient not found']);
        }
        $question = $doctor->questions()->get()->find($id);
        if ($question) {
            $data = $request->all();
            $question->update($data);
            return response()->json(['status_code' => 200, 'data' => new QuestionResource($question)]);
        }
        return response()->json([
            'status_code' => 404,
            'message' => 'ID not found'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($doctor_id, $id)
    {
        $question = Doctor::find($doctor_id)->questions()->find($id);
        if ($question) {
            $question->delete();
            return response()->json(['status_code' => 204]);
        }
        return response()->json(['status_code' => 401, 'message' => 'ID not found']);
    }
}
