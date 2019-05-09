<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MyValidation;
use App\Http\Resources\MyCollection;
use App\Http\Resources\MyResource;
use App\Question;
use Validator;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('doctor', 'patient')->orderBy('id', 'desc')->get();
        if ($questions) {
            return response()->json([
                'status_code' => 200, 'data' => new QuestionCollection($questions)
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
        $validator = Validator::make($request->all(), MyValidation::$ruleQuestion, MyValidation::$messageQuestion);
        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return response()->json(['status_code' => 202, 'message' => $message], 202);
        }
        $question = Question::create($request->all());
        if ($question) {
            return response()->json(['status_code' => 201, 'data' =>  new QuestionResource($question)], 201);
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
        return MyController::show('App\\Question', $id);
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
        return MyController::update($request, $id, 'App\\Question');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $question = Question::find($id);
       if($question){
           $question->delete();
           return response()->json(['status_code' => 204]);
       }
       return response()->json(['status_code' => 202, 'message' => 'ID not found']);
    }
}
