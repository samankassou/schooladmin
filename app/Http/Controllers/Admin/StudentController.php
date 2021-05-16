<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\AcademicYear;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Student::orderBy('firstname')->get())
                ->addIndexColumn()
                ->addColumn('action', function(Student $student){
                    $actionBtns = "<a href='/admin/students/$student->id' class='btn btn-sm btn-primary'><i class='bi bi-eye'></i></a>";
                    $actionBtns .= "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-student-modal' onclick='edit_student(".$student->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-student-modal' onclick='delete_student(".$student->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $classrooms = Classroom::where(['academic_year_id' => AcademicYear::current()->id])->get();
        return view('admin.students.index', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        $student = Student::create(Arr::except($request->validated(), ['classroom']));
        $student->classrooms()->attach([$request->classroom]);
        return response()->json(['message' => 'Student successfully created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return response()->json(['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update(Arr::except($request->validated() + ['father_name' => $request->father_name], ['classroom']));
        $student->classrooms()->detach($student->current_classroom);
        $student->classrooms()->attach($request->classroom);
        return response()->json(['message' => 'Student updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->classrooms()->detach();
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully!']);
    }
}
