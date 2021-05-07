<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teachers = User::role('Enseignant')->with(['courses'])->get()
        ->each(function($teacher){
            $teacher->avatar_url = !empty($teacher->avatar) ? $teacher->avatar->getUrl('avatar-thumb') : null;
        });
        
        if ($request->ajax()) {
            return Datatables::of($teachers)
                ->addIndexColumn()
                ->addColumn('action', function($teacher){
                    $actionBtns = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-teacher-modal' onclick='edit_teacher(".$teacher->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-teacher-modal' onclick='showDeleteTeacherModal(".$teacher->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $courses = Course::all();
        return view('admin.teachers.index', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => true,
            'password' => bcrypt('passsword')
        ]);
        if($request->hasFile('avatar')){
            $teacher->addMediaFromRequest('avatar')->toMediaCollection('avatars', 'public');
        }
        $teacher->courses()->attach($request->courses);
        $teacher->assignRole('Enseignant');

        return response()->json(['message' => 'Teacher created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = User::find($id);
        $teacher->courses()->detach();
        $teacher->delete();
        return response()->json(['message' => 'Teacher deleted!']);
    }
}
