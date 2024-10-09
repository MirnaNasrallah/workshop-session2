<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Student;
use App\Models\School;
use Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


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
    public function assignStudent($student_id)
    {
        $student = Student::findOrFail($student_id);
        $student_score = $student->last_year_score;
        $student_location = $student->location;

        $schoolId = null;

        //join school score > min, has capacity, same location
        $matching_schools =  School::where('minimum_score', '<=', $student_score)
            ->where('location', $student_location)
            ->get();
        // $matching_schools = DB::statement('SELECT * FROM ')
        foreach ($matching_schools as $school) {
            if ($school->available_slots > 0) {
                $schoolId = $school->id;
                break;
            }
        }

        if (!$schoolId) {
            //student location = location_from , school location : location_to .
            //a2al distance between that student and any available school
            $nearest_location = Location::where('location_from', $student_location)
                ->orderBy('distance')
                ->first('location_to');

            // if nearest location exists, find school min score < student score
            if ($nearest_location) {
                $nearest_schools = School::where('minimum_score', '<=', $student_score)
                    ->where('location', $nearest_location->location_to)
                    ->get();

                foreach ($nearest_schools as $school) {
                    if ($school->available_slots > 0) {
                        $schoolId = $school->id;
                        break;
                    }
                }
            }
        }
        if ($schoolId) {
            //increment student count by 1
            //decrement available slots by 1
            //fields in table school
            $school->decrement('available_slots');
            $school->increment('student_count');
            $student->school_id = $schoolId;
            $student->save();
        } else {
            //student did not get assigned

        }
        return ;
    }
    public function assignStudents()
    {
        $students = Student::all();
        // student assigned according to their scores
        // min school accept
        // availability of the student count school
        foreach ($students as $student) {
            $this->assignStudent($student->id);
        }
        Alert::success('Success', 'Students assigned successfully');
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
        // Student::wherenotnull('school_id')->update(['school_id' => null]);
        //get all assigned students
        $students = Student::whereNotNull('school_id')->get();
        foreach ($students as $student) {
            //find the school that this student is assigned to
            $school = School::find($student->school_id);
            if ($school) {
                //decrement student_count by 1
                $school->decrement('student_count');
                //increment available slots by 1
                $school->increment('available_slots');
            }
        }

        Student::wherenotnull('school_id')->update(['school_id' => null]);
        Alert::warning('Success', 'All Students unassigned');
        return redirect()->back()->with('success');
    }
}
