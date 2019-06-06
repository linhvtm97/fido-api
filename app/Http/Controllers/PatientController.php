<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Library\MyValidation;
use DB;
use App\Http\Resources\PatientResource;
use App\Patient;
use App\Http\Resources\PatientCollection;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Patient::with('address', 'questions', 'ratings')->orderBy('id', 'asc')->get();
        if ($results) {
            return response()->json([
                'status_code' => 200, 'data' => new PatientCollection($results)
            ], 200);
        }
        return response()->json([
            'status_code' => 204
        ], 204);
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
        return MyController::store($request, 'App\\Patient', MyValidation::$rulePatient, MyValidation::$messagePatient);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::with('address', 'ratings', 'questions')->find($id);
        if ($patient) {
            return response()->json(['status_code' => 200, 'data' => new PatientResource($patient)], 200);
        }
        return response()->json(['status_code' => 404, 'message' => 'ID not found'], 404);
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
        return MyController::update($request, $id, 'App\\Patient');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MyController::destroy($id, 'App\\Patient');
    }
}
