<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Project;
use App\Models\Customer;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('user_id',Auth::user()->id)->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $request->validated();

        $customer = new Customer;
        $customer->name = $request->input('customer_name');
        $customer->phone_number = $request->input('customer_phone_number');
        $customer->save();

        $project = new Project;
        $project->user_id = Auth::user()->id;
        $project->customer_id = $customer->id;
        $project->name = $request->input('project_name');
        $project->property_type = $request->input('property_type');
        $project->development_name = $request->input('development_name');
        $project->area_name = $request->input('area_name');
        $project->gps_position = $request->input('gps_position');

        $path = $request->file('image_file')->store('public');
        $project->image = $path;
        
        $project->save();

        
        return redirect(route('projects.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return view('projects.detail')->with(['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.form')->with(['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $request->validated();

        $project = Project::findOrFail($id);

        $customer = Customer::findOrFail($project->customer->id);
        $customer->name = $request->input('customer_name');
        $customer->phone_number = $request->input('customer_phone_number');
        $customer->save();

        $project->name = $request->input('project_name');
        $project->property_type = $request->input('property_type');
        $project->development_name = $request->input('development_name');
        $project->area_name = $request->input('area_name');
        $project->gps_position = $request->input('gps_position');

        if(!empty($request->file('image_file'))){
            $path = $request->file('image_file')->store('public');
            $project->image = $path;
        }
        $project->save();

        
        return redirect(route('projects.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        Storage::delete($project->image);
        $project->delete(); //returns true/false

        return redirect(route('projects.index'));
    }
}
