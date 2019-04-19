<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MyCollection;
use App\Employee;
use Validator;
use App\Library\MyValidation;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MyCollection(Employee::all());
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
        $validator = Validator::make($request->all(), MyValidation::$ruleEmployee, MyValidation::$messageEmployee);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json([$message], 401);    
        }
        $empl = Employee::create($request->all());
        if($empl){
            return new EmployeeResource($empl);
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
        $empl = Employee::find($id);
        if ($empl) {
            return new EmployeeResource($empl);
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
        $empl = Employee::find($id);
        if ($empl) {
            $data = $request->all();
            $empl->update($data);
            return new EmployeeResource($empl);
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
        $empl = Employee::find($id);
        if ($empl) {
            $empl->delete();
            return response()->json(['message' => 'Deleted']);   
        }
        return response()->json(['error' => 'ID not found']);   
    }
}
