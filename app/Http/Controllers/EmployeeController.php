<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\EmployeeServiceInterface;
use \Exception;

class EmployeeController extends Controller
{
    protected $employeeService;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeServiceInterface $employeeService
     */
    public function __construct(EmployeeServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeeService->all();
        if (!$employees) {
            return response()->json(['Message' => 'No content'], 204);
        }
        return response()->json(['Message' => 'Success', 'Data' => $employees], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->employeeService->create($request->all());
        } catch (\Exception $th) {
            return response()->json(['Message' => $th->getMessage()], 202);
        }
        return response()->json(['Message' => 'Created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $employee = $this->employeeService->find($id);
        } catch (\Exception $th) {
            return response()->json(['Message' => $th->getMessage()], 404);
        }
        return response()->json(['Message' => 'Success', 'Data' => $employee], 200);
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
        try {
            $this->employeeService->update($request->all(), $id);
        } catch (\Exception $th) {
            return response()->json(['Message' => $th->getMessage()], 404);
        }
        return response()->json(['Message' => 'Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->employeeService->delete($id);
        } catch (\Exception $th) {
            return response()->json(['Message' => $th->getMessage()], 404);
        }
        return response()->json(['Message' => 'Deleted'], 202);
    }
}
