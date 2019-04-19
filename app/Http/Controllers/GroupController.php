<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Http\Resources\GroupResource;
use App\Http\Resources\MyCollection;
use App\Library\MyResponse;
use Validator;
use App\Library\MyValidation;

// define('ERROR', 1);
// define('SUCCESS', 0);


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MyCollection(Group::all());
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
        $validator = Validator::make($request->all(), MyValidation::$ruleGroup, MyValidation::$messageUser);

        if ($validator->fails()) {
            $message = $validator->messages()->getMessages();
            return [new MyResponse(ERROR, $message)];
        }
        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->status = $request->input('status');
        $group->save();

        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::find($id);
        if ($group) {
            return new GroupResource($group);
        }

        return "Group Not found"; // temporary error
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

        $group = Group::find($id);
        if ($group) {
            $groupUpdated = $request->all();
            $group->update($groupUpdated);
            return new GroupResource($group);
        }
        return [new MyResponse(ERROR, "Can not find id")];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        if ($group) {
            $group->delete();
            return "Deleted";
        }
        return "ID not found";
    }
}
