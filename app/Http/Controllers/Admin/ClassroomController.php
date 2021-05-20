<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Level;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Classroom::where('academic_year_id', AcademicYear::current()->id)->with(['level', 'headTeacher'])->get())
                ->addIndexColumn()
                ->addColumn('action', function(Classroom $classroom){
                    $actionBtns = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-classroom-modal' onclick='showEditClassroomModal(".$classroom->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-classroom-modal' onclick='showDeleteClassroomModal(".$classroom->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $levels = Level::all();
        $teachers = User::role('Enseignant')->get();
        return view('admin.classrooms.index', compact('levels', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassroomRequest $request)
    {
        Classroom::create([
            'name' => $request->name,
            'level_id' => $request->level,
            'academic_year_id' => AcademicYear::current()->id,
            'head_teacher' => $request->head_teacher
        ]);
        return response()->json(['message' => 'Classroom created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        return response()->json(['classroom' => $classroom]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassroomRequest $request, Classroom $classroom)
    {
        $classroom->name = $request->name;
        $classroom->level_id = $request->level;
        $classroom->head_teacher = $request->head_teacher;
        $classroom->save();
        return response()->json(['message' => 'Classroom updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        if(count($classroom->students) != 0){
            return response()->json(['success' => false, 'message' => 'This Classroom has some students!']);
        }

        $classroom->delete();
        return response()->json(['success' => true, 'message' => 'Classroom deleted successfully!']);
    }
}
