<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new GroupResource(Group::paginate());
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
        $article = Group::find($id); //id comes from route

        if ($article) {

            return new GroupResource($article);
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

        $group->name = $request->input('name');

        $group->descriptiop = $request->input('description');

        $group->status = $request->input('status');

        $group->save();

        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrfail($id);

        if ($group->delete()) {

            return  new GroupResource($group);
        }

        return "Error while deleting";
    }
}
