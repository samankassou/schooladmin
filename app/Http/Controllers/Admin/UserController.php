<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
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
        if($request->ajax()){
            $users = 
            $users = User::role(['Admin', 'Proviseur'])->get(['id', 'name', 'email', 'status'])
            ->each(function($user){
                $user->avatar_url = !empty($user->avatar) ? $user->avatar->getUrl('avatar-thumb') : null;
                $user->role = $user->roles[0];
                unset($user->media);
            });
            return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function($user){
                $checked =  ($user->status == 1) ? "checked" : "";
                $btn = '<div class="form-check form-switch">
                            <input class="form-check-input" style="cursor: pointer" onclick="toggleUserStatus('.$user->id.')" type="checkbox" '.$checked.'>
                        </div>';
                return $btn;
            })
            ->addColumn('action', function($user){
                $actionBtns = "<a href='/admin/users/$user->id' class='btn btn-sm btn-primary'><i class='bi bi-eye'></i></a>";
                $actionBtns .= "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-user-modal' onclick='showEditUserModal(".$user->id.")'><i class='bi bi-pencil'></i></button>";
                $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-user-modal' onclick='showDeleteUserModal(".$user->id.")'><i class='bi bi-trash'></i></button>";
                return $actionBtns;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
        $usersRoles = Role::whereNotIn('name', ['Enseignant'])->get();
        return view('admin.users.index', compact('usersRoles'));
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
        $password = Str::random(8);
        $EncryptedPassword = bcrypt($password);
        
        $user = User::create($request->validated() + ['password' => $EncryptedPassword]);
        if($request->hasFile('avatar')){
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars', 'public');
        }
        $user->assignRole(Role::findById($request->role)->name);

        $user->password = $password;
        //Mail::to($user)->send(new WelcomeEmail($user));

        return response()->json(['message' => 'User created successfully!']);
    }

    public function toggleUserStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();

        return response()->json(['message' => 'User\'s status updated']);
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
        $user->avatar_url = !empty($user->avatar) ? $user->avatar->getUrl('avatar-thumb') : null;
        return response()->json([
            'user' => $user
        ]);
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
            return response()->json(['message' => 'You cannot delete this user']);
        }
        $user->courses()->detach();
        $user->delete();
        return response()->json(['message' => 'User deleted!']);
    }
}
