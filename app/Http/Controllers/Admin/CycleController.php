<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cycle;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCycleRequest;
use App\Http\Requests\UpdateCycleRequest;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Cycle::all('id', 'name'))
                ->addIndexColumn()
                ->addColumn('action', function($cycle){
                    $actionBtns = "<button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#edit-cycle-modal' onclick='showEditCycleModal(".$cycle->id.")'><i class='bi bi-pencil'></i></button>";
                    $actionBtns .= "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#delete-cycle-modal' onclick='showDeleteCycleModal(".$cycle->id.")'><i class='bi bi-trash'></i></button>";
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.cycles.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCycleRequest $request)
    {
        Cycle::create($request->validated());
        return response()->json(['message' => 'cycle created duccessfully!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cycle  $cycle
     * @return \Illuminate\Http\Response
     */
    public function show(Cycle $cycle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cycle  $cycle
     * @return \Illuminate\Http\Response
     */
    public function edit(Cycle $cycle)
    {
        return response()->json(['cycle' => $cycle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cycle  $cycle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCycleRequest $request, Cycle $cycle)
    {
        $cycle->update($request->validated());
        return response()->json(['message' => 'Cycle updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cycle  $cycle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cycle $cycle)
    {
        if(count($cycle->levels) != 0){
            return response()->json(['success' => false, 'message' => 'This Cycle has some levels!']);
        }

        $cycle->delete();
        return response()->json(['success' => true, 'message' => 'Cycle deleted successfully!']);
    }
}
