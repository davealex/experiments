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

    public function register(Request $request)
    {
        Course::registerCourses($request->courses, $request->users);

        return response([
            'users' => User::all()
        ], 200);
    }
}
