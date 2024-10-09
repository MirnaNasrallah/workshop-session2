<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function show($id)
    {
       $school = School::findOrFail($id);
    //   $school = DB::connection('mysql2')->table('schools')->select('id')
    //   ->where('id',$id);
        //to connect to multiple databases we use the following:
      //  $main_connection = DB::connection('mysql2');

     //  $school =$main_connection->select("SELECT * FROM schools WHERE id = $id");
    // dd($school);
        return view('schools',['school'=>$school]);

    }
}
