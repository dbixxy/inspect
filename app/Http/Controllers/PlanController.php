<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Project;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        $plans = Plan::where('project_id', $project_id)->get();
        return view('plans.index')->with(['plans' => $plans, 'project_id' => $project_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        return view('plans.form')->with(['project_id' => $project_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request, $project_id)
    {
        // Plan::create($request->validated());
        $request->validated();

        $plan = new Plan;
        $plan->project_id = $request->input('project_id');
        $plan->name = $request->input('name');
        $plan->floor_number = $request->input('floor_number');

        $path = $request->file('image')->store('public');
        $plan->image = $path;
        
        $plan->save();

        return redirect(route('plans.index', $project_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = Plan::findOrFail($id);

        return view('plans.detail')->with(['project_id' => $plan->project->id, 'plan' => $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $id)
    {
        $plan = Plan::findOrFail($id);
        return view('plans.form')->with(['project_id' => $project_id, 'plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $project_id, $id)
    {
        $request->validated();

        $plan = Plan::findOrFail($id);
        $plan->name = $request->input('name');
        $plan->floor_number = $request->input('floor_number');

        if(!empty($request->file('image'))){
            $path = $request->file('image')->store('public');
            $plan->image = $path;
        }
        $plan->save();

        
        return redirect(route('plans.index', $project_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $id)
    {
        $plan = Plan::findOrFail($id);
        Storage::delete($plan->image);
        $plan->delete(); //returns true/false

        return redirect(route('plans.index', $project_id));
    }
}
