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
            return Datatables::of(Student::all())
                ->addIndexColumn()
                ->addColumn('action', function(Student $student){
                    $actionBtns = "<a href='/admin/students/$student->id' class='btn btn-sm btn-primary'><i class='bi bi-eye'></i></a>";
                    $actionBtns .= "<a href='/admin/students/$student->id' class='btn btn-sm btn-primary'><i class='bi bi-eye'></i></a>";
                    $actionBtns .= "<a href='/admin/students/$student->id' class='btn btn-sm btn-primary'><i class='bi bi-eye'></i></a>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $classrooms = Classroom::all();
        return view('admin.students.index2', compact('classrooms'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return StudentResource::collection(Student::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
