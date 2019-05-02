<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use DB;
use App\Http\Resources\DoctorCollection;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $data = $request->all();
        $doctors = DB::table('doctors')->where('name', 'LIKE', '%'.$data['name'].'%')
            ->orWhere('specialist_id', '=', $data['specialist_id'])
            ->orWhere('address_id', '=', $data['address_id'])
            ->orderBy('id', 'asc')->with('address', 'specialist', 'sub_specialist', 'employee', 'ratings')->get();

        return new DoctorCollection($doctors);
    }
}
