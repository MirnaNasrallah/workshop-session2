<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function show($id)
    {
        $school = School::findOrFail($id);
        return view('schools',['school'=>$school]);
    }
}
