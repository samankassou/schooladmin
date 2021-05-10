<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
        if ($request->ajax()) {
            $teachers = User::role('Enseignant')->with(['courses'])->get()
            ->each(function($teacher){
                $teacher->avatar_url = !empty($teacher->avatar) ? $teacher->avatar->getUrl('avatar-thumb') : null;
            });
            return Datatables::of($teachers)
                ->addIndexColumn()
                ->addColumn('status', function($teacher){
                    $checked =  ($teacher->status == 1) ? "checked" : "";
                    $btn = '<div class="form-check form-switch">
                                <input class="form-check-input" style="cursor: pointer" onclick="toggleTeacherStatus('.$teacher->id.')" type="checkbox" '.$checked.'>
                            </div>';
                    return $btn;
                })
                ->addColumn('action', function($teacher){
                    $actionBtns = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-teacher-modal' onclick='showEditTeacherModal(".$teacher->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-teacher-modal' onclick='showDeleteTeacherModal(".$teacher->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['status','action'])
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
        $password = Str::random(8);
        $EncryptedPassword = bcrypt($password);

        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => true,
            'password' => $EncryptedPassword
        ]);
        if($request->hasFile('avatar')){
            $teacher->addMediaFromRequest('avatar')->toMediaCollection('avatars', 'public');
        }
        $teacher->courses()->attach($request->courses);
        $teacher->assignRole('Enseignant');

        $teacher->password = $password;
        //Mail::to($teacher)->send(new WelcomeEmail($teacher));
        return response()->json(['message' => 'Teacher created successfully!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = User::find($id);
        $teacher->avatar_url = !empty($teacher->avatar) ? $teacher->avatar->getUrl('avatar-thumb') : null;
        return response()->json([
            'teacher' => $teacher
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $teacher = User::find($id);
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->save();
        return response()->json([
            'message' => 'Teacher created successfully!',
        ]);
    }

    public function toggleTeacherStatus(User $teacher)
    {
        $teacher->status = !$teacher->status;
        $teacher->save();
        return response()->json(['message' => 'Teacher\'s status updated']);
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
