<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Student;
use App\Models\School;
use Directory;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //function to assign students to schools
    //restrictions: student can be assigned to the school only if their grade in equal or more that
    //the min score required the school
    public function showStudents()
    {
        $students = Student::all();
        return view('dashboard', compact('students'));
    }
    public function getDistance($student_location, $school_location)
    {
        $location = Location::where('location_from', $student_location)
            ->where('location_to', $school_location)
            ->first();

        return $location ? $location->distance : PHP_INT_MAX;
    }
    public function findNearestLocation($student)
    {
        //school which its location distance from the student's location is minimum
        //to_location - from_location = minimum distance
        //to_location = school's location, from_location = $studnet_location

        $student_location = $student->location;
        $schools = School::all();

        $nearest_school = null;
        $min_distance = PHP_INT_MAX;
        foreach ($schools as $school) {
            $school_location = $school->location;
            $distance = $this->getDistance($student_location, $school_location);
            if ($student_location == $school_location) {
                $nearest_school = School::where('location', $student->location)->first();
                break;
                if ($distance < $min_distance) {
                    $min_distance = $distance;
                    $nearest_school = $school;
                }

            }
        }
        return $nearest_school;
    }

    public function assignStudents()
    {
        //  $school_id = $request->all();
        $students = Student::all();
        $schools = School::all();
        $nearest_school = null;

        foreach ($students as $student) {

            if ($student->school_id == null) {
                foreach ($schools as $school) {

                    if ($student->last_year_score >= $school->minimum_score) {
                        $student->school_id = $school->id;
                        $student->save();

                        break;
                    } else {
                        $nearest_school = $this->findNearestLocation($student);
                        if ($nearest_school) {
                            $student->school_id = $nearest_school->id;
                            $student->save();
                            break;
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('success');
    }
    public function reset()
    {
        //    $students =  Student::all();
        //     foreach($students as $student)
        //     {
        //         $student->school_id = null;
        //         $student->save();
        //     }
        Student::wherenotnull('school_id')->update(['school_id' => null]);
        return redirect()->back()->with('success');
    }
}
