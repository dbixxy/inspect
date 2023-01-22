<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Project;
use App\Models\Customer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Project::where('user_id',Auth::user()->id)->get();
        $inspects_count = 0;
        $issues_count = 0;
        $issues_closed = 0;
        $pjs = Project::has('issues')->get();
        foreach ($projects as $pj) {
            $inspects_count += $pj->inspects()->count(); 
            $issues_count  += $pj->issues()->count();
            $issues_closed += $pj->issues()->where('is_closed', 1)->count();
        }

        $success_percent = 0;
        if(!empty($issues_count)){
            $success_percent =  ($issues_closed / $issues_count) * 100;
        }
        $success_percent = round($success_percent, 0);
        return view('home', ['projects' => $projects, 'inspects_count' => $inspects_count, 'issues_count' => $issues_count, 'success_percent' => $success_percent]);
    }
}
