<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all(['id', 'name', 'email', 'status'])->each(function($user){
            $user->avatar_url = !empty($user->avatar) ? $user->avatar->getUrl('avatar-thumb') : null;
            unset($user->media);
        });
        if($request->ajax()){
            return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function(User $user){
                $actionBtns = "<a href='/admin/users/$user->id' class='btn btn-sm btn-primary'><i class='bi bi-eye'></i></a>";
                $actionBtns .= "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-user-modal' onclick='edit_user(".$user->id.")'><i class='bi bi-pencil'></i></button>";
                $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-user-modal' onclick='delete_user(".$user->id.")'><i class='bi bi-trash'></i></button>";
                return $actionBtns;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $password = bcrypt(Str::random(8));
        
        $user = User::create($request->validated() + ['password' => $password]);
        if($request->hasFile('avatar')){
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars', 'public');
        }
        return response()->json(['message' => 'User created successfully!']);
    }

    public function toggleStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'alert' => 'success',
            'message' => 'User status updated'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('admin.users.index')->with([
            'alert' => 'success',
            'message' => 'Utilisateur modifié'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(auth()->user()->id == $user->id){
            return response()->json(['message' => 'User deleted!']);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted!']);
    }
}
