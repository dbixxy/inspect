<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IssueRequest;
use App\Models\Project;
use App\Models\Inspect;
use App\Models\Plan;
use App\Models\Issue;
use App\Models\IssueFile;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id, $inspect_id)
    {
        $project = Project::findOrFail($project_id);
        $inspect = Inspect::findOrFail($inspect_id);
        $plans = Plan::where('project_id', $project_id)->get();
        $issues = $project->issues;
        return view('issues.index')->with(['issues' => $issues, 'plans' => $plans, 'inspect' => $inspect, 'project_id' => $project_id, 'inspect_id' => $inspect_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id , $inspect_id)
    {
        $project = Project::findOrFail($project_id);
        $inspect = Inspect::findOrFail($inspect_id);
        $issue_count = $project->issues->max('number') + 1;
        $plans = Plan::where('project_id', $project_id)->get();
        $issues = $project->issues;
        return view('issues.form')->with(['project_id' => $project_id, 'inspect_id' => $inspect_id, 'issue_count' => $issue_count, 'plans' => $plans, 'inspect' => $inspect, 'issues' => $issues]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IssueRequest $request, $project_id, $inspect_id)
    {
        $request->validated();

        $issue = new Issue;
        $issue->inspect_id = $request->input('inspect_id');
        $issue->plan_id = $request->input('plan_id');
        $issue->number = $request->input('number');
        $issue->position_x = $request->input('position_x');
        $issue->position_y = $request->input('position_y');
        $issue->problem = $request->input('problem');
        $issue->suggest = $request->input('suggest');
        $issue->ref_issue_id = $request->input('ref_issue_id');
        if($request->input('is_closed') == true){
            $issue->is_closed = $request->input('is_closed');
            $issue->close_at_inspect_id = $request->input('inspect_id');
        }
        $issue->save();

        $files = $request->file('files');
        if(!empty($files)){
            foreach($files as $file){
                $issue_file = new IssueFile;
                $issue_file->issue_id = $issue->id;
                $path = $file->store('public');
                $issue_file->file = $path;
                $issue_file->save();
            }
        }
        
        
        return redirect(route('issues.index', ['project_id' => $project_id, 'inspect_id' => $inspect_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_id , $inspect_id, $id)
    {
        $inspect = Inspect::findOrFail($inspect_id);
        $issue = Issue::findORFail($id);
        $issue_files = IssueFile::where('issue_id', $id)->get();
        return view('issues.detail')->with(['project_id' => $project_id, 'inspect_id' => $inspect_id, 'issue' => $issue, 'inspect' => $inspect, 'issue_files' => $issue_files]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id , $inspect_id, $id)
    {
        $project = Project::findOrFail($project_id);
        $inspect = Inspect::findOrFail($inspect_id);
        $issue = Issue::findORFail($id);
        $plans = Plan::where('project_id', $project_id)->get();
        $issues = $project->issues;
        $issue_files = IssueFile::where('issue_id', $id)->get();
        return view('issues.form')->with(['project_id' => $project_id, 'inspect_id' => $inspect_id, 'issue' => $issue, 'plans' => $plans, 'inspect' => $inspect, 'issues' => $issues, 'issue_files' => $issue_files]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IssueRequest $request, $project_id , $inspect_id, $id)
    {
        $request->validated();

        $issue = Issue::findOrFail($id);
        $issue->plan_id = $request->input('plan_id');
        $issue->number = $request->input('number');
        $issue->position_x = $request->input('position_x');
        $issue->position_y = $request->input('position_y');
        $issue->problem = $request->input('problem');
        $issue->suggest = $request->input('suggest');
        $issue->ref_issue_id = $request->input('ref_issue_id');
        if($request->input('is_closed') == true){
            $issue->is_closed = $request->input('is_closed');
            $issue->close_at_inspect_id = $request->input('inspect_id');
        }
        $issue->save();

        $files = $request->file('files');
        if(!empty($files)){
            foreach($files as $file){
                $issue_file = new IssueFile;
                $issue_file->issue_id = $issue->id;
                $path = $file->store('public');
                $issue_file->file = $path;
                $issue_file->save();
            }
        }
        
        return redirect(route('issues.index', ['project_id' => $project_id, 'inspect_id' => $inspect_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $inspect_id, $id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete(); //returns true/false

        return redirect(route('issues.index', [$project_id, $inspect_id]));
    }
}
