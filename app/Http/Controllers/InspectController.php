<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InspectRequest;
use App\Models\Project;
use App\Models\Inspect;

class InspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        $inspects = Inspect::where('project_id', $project_id)->get();
        return view('inspects.index')->with(['inspects' => $inspects, 'project_id' => $project_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        $inspect_count = Inspect::where('project_id', $project_id)->count();
        $inspect_count += 1;
        return view('inspects.form')->with(['project_id' => $project_id, 'inspect_count' => $inspect_count]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InspectRequest $request, $project_id)
    {
        // Inspect::create($request->validated());
        $request->validated();

        $inspect = new Inspect;
        $inspect->project_id = $request->input('project_id');
        $inspect->number = $request->input('number');
        $inspect->date_start = $request->input('date_start');
        $inspect->date_end = $request->input('date_end');
        $inspect->save();

        return redirect(route('inspects.index', $project_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inspect = Inspect::findOrFail($id);

        return view('inspects.detail')->with(['project_id' => $inspect->project->id, 'inspect' => $inspect]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $id)
    {
        $inspect = Inspect::findOrFail($id);
        return view('inspects.form')->with(['project_id' => $project_id, 'inspect' => $inspect]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InspectRequest $request, $project_id, $id)
    {
        $request->validated();

        $inspect = Inspect::findOrFail($id);
        $inspect->number = $request->input('number');
        $inspect->date_start = $request->input('date_start');
        $inspect->date_end = $request->input('date_end');
        $inspect->save();

        return redirect(route('inspects.index', $project_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $id)
    {
        $inspect = Inspect::findOrFail($id);
        $inspect->delete(); //returns true/false

        return redirect(route('inspects.index', $project_id));
    }
}
