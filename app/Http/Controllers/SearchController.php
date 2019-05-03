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
        $data = array(
            'name' => $request->name,
            'specialist_id' => $request->specialist_id,
            'address_id' => $request->address_id
        );
        $doctors = Doctor::with('address', 'specialist', 'sub_specialist', 'employee', 'ratings')->where('name', 'LIKE', '%'.$data['name'].'%')
            ->orWhere('specialist_id', '=', $data['specialist_id'])
            ->orWhere('address_id', '=', $data['address_id'])
            ->orderBy('id', 'asc')->get();

        return new DoctorCollection($doctors);
    }
}
