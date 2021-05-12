<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Course::where('academic_year_id', AcademicYear::current()->id)->get())
                ->addIndexColumn()
                ->addColumn('action', function($course){
                    $actionBtns = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-course-modal' onclick='edit_course(".$course->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-course-modal' onclick='showDeleteCourseModal(".$course->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.courses.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated() + ['academic_year_id' => AcademicYear::current()->id]);
        return response()->json(['message' => 'Course created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if(count($course->teachers) != 0){
            return response()->json(['success' => false, 'message' => 'This Course has some teachers!']);
        }

        $course->delete();
        return response()->json(['success' => true, 'message' => 'Course deleted successfully!']);
    }
}
