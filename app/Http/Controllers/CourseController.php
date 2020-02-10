<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function enrolment()
    {
        return view('enrolment', [
            'users' => User::all(),
            'courses' => Course::all()
        ]);
    }

    public function enrol(Request $request)
    {
        Course::registerCourses($request->courses, $request->users);

        return response([
            'enrolled' => User::find($request->users)
        ], 200);
    }
}
