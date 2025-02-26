<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Departement;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
   
    $applicantData = Applicant::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

   
    $jobData = Job::select('department', DB::raw('count(*) as count'))
        ->groupBy('department')
        ->get();

  
    $departments = Departement::all()->pluck('dep_name', 'id')->toArray();
    $departmentCounts = [];

    
    foreach ($jobData as $data) {
        if (isset($departments[$data->department])) {
            $departmentCounts[$departments[$data->department]] = $data->count;
        }
    }

    
    $jobCounts = Job::withCount('applicants') 
        ->get()
        ->pluck('applicants_count', 'job_name') 
        ->toArray();

    return view('home', compact('applicantData', 'departmentCounts', 'jobCounts'));
}

}
