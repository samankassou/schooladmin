<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cycle;
use App\Models\Level;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Level::with('cycle')->get())
                ->addIndexColumn()
                ->addColumn('action', function($level){
                    $actionBtns = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-level-modal' onclick='showEditLevelModal(".$level->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-level-modal' onclick='showDeleteLevelModal(".$level->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $cycles = Cycle::all();
        return view('admin.levels.index', compact('cycles'));
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
    public function store(StoreLevelRequest $request)
    {
        $level = new Level;
        $level->name = $request->name;
        $level->cycle_id = $request->cycle;
        $level->save();
        
        return response()->json(['message' => 'Level saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        return response()->json(['level' => $level]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLevelRequest $request, Level $level)
    {
        $level->name = $request->name;
        $level->cycle_id = $request->cycle;
        $level->save();
        return response()->json(['message' => 'Level updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        if(count($level->classrooms) != 0){
            return response()->json(['success' => false, 'message' => 'This Level has some classrooms!']);
        }

        $level->delete();
        return response()->json(['success' => true, 'message' => 'Level deleted successfully!']);
    }
}
