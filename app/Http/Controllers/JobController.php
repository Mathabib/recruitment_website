<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\WorkLocation;
use App\Models\Job as ModelsJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Display all jobs or filter by department
public function index(Request $request)
{
    // Default per page = 20
    $perPage = $request->get('perPage', 'all');

    $query = ModelsJob::query();

    // Filter search
    if ($request->filled('search')) {
        $query->where('job_name', 'like', '%'.$request->search.'%');
    }

    // Filter status
    if ($request->filled('status_published')) {
        $query->where('status_published', $request->status_published);
    }

    // Sort
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'asc':
                $query->orderBy('job_name', 'asc');
                break;
            case 'desc':
                $query->orderBy('job_name', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    // Hitung total jobs (akumulasi semua)
    $totalJobs = $query->count();

    // Pagination (jika pilih "all" tampilkan semua data)
    if ($perPage === 'all') {
        $jobs = $query->get();
    } else {
        $jobs = $query->paginate((int)$perPage)->appends($request->query());
    }

    return view('jobs.index', compact('jobs', 'totalJobs', 'perPage'));
}



    // Show the form for creating a new job
    public function create()
    {
        $departements = Departement::all(); // Fetch all departments
        $workLocations = WorkLocation::all(); // Fetch all work locations

        return view('jobs.create', compact('departements', 'workLocations'));
    }

    // Store a new job in the database
    public function store(Request $request)
    {
        
        // Validate input
        $request->validate([
            'job_name' => 'required|string|max:255',
            'work_location_id' => 'required|exists:work_location,id', // Validate that work_location_id exists
            'department' => 'required|exists:departements,id',
            'employment_type' => 'required|string',
            'minimum_salary' => 'required',
            'maximum_salary' => 'required',
            'benefit' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'spesifikasi' => 'nullable|string',

        ]);
        $minimum_salary = $request->input('minimum_salary');
        $minimum_salary = str_replace(['.', ','], '', $minimum_salary);
        $minimum_salary = (int) $minimum_salary;

        $maximum_salary = $request->input('maximum_salary');
        $maximum_salary = str_replace(['.', ','], '', $maximum_salary);
        $maximum_salary = (int) $maximum_salary;
        
        //overide isi $request minimum_salary dan maximum salary 
        $request->merge([
            'minimum_salary' => (int) $minimum_salary,
            'maximum_salary' => (int) $maximum_salary,
        ]);

        // @dd($request);

        // dd($request->all()); // This will dump the request data and halt execution
        ModelsJob::create($request->all());


        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    // Show the form to edit an existing job
    public function edit($id)
    {
        // Ambil job berdasarkan ID
        $job = ModelsJob::findOrFail($id);
        $minimum_salary = number_format($job->minimum_salary, 0, ',', '.');
        $maximum_salary = number_format($job->maximum_salary, 0, ',', '.');
        // Ambil data work_location dan departement jika ingin ditampilkan dalam dropdown
        $work_locations = WorkLocation::all();
        $departments = Departement::all();
        
        // Tampilkan halaman edit dengan data job
        return view('jobs.edit', compact('job', 'work_locations', 'departments', 'minimum_salary', 'maximum_salary'));
    }

    public function update(Request $request, $id)
    {
        // return $request;
        // Validasi input
        $request->validate([
            'job_name' => 'required|string|max:255',
            'work_location_id' => 'required|exists:work_location,id', // Validasi bahwa work_location_id ada
            'department' => 'required|exists:departements,id',
            'employment_type' => 'required|string',
            'minimum_salary' => 'required',
            'maximum_salary' => 'required',
            'benefit' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
        ]);

        // Cari job berdasarkan ID
        $job = ModelsJob::findOrFail($id);
        $minimum_salary = $request->input('minimum_salary');
        $minimum_salary = str_replace(['.', ','], '', $minimum_salary);
        $minimum_salary = (int) $minimum_salary;

        $maximum_salary = $request->input('maximum_salary');
        $maximum_salary = str_replace(['.', ','], '', $maximum_salary);
        $maximum_salary = (int) $maximum_salary;
        
        //overide isi $request minimum_salary dan maximum salary 
        $request->merge([
            'minimum_salary' => (int) $minimum_salary,
            'maximum_salary' => (int) $maximum_salary,
        ]);

        $job->update($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    // Delete a job from the database
    public function destroy($id)
    {
        // Find and delete the job
        $job = ModelsJob::find($id);

        if ($job) $job->delete();
        return redirect()->route('jobs.index')->with('success_message', 'Job deleted successfully.');
    }
    public function getJobData()
    {
        $jobs = ModelsJob::with('workLocation')->get();

        dd($jobs->toArray());

        return response()->json($jobs);
    }

    public function updateStatus(Request $request, $id) {
        $job = ModelsJob::find($id);
        $job->status_published = $request->input('status_published');
        $job->save();
    
        return redirect()->back()->with('success', 'Job status updated successfully.');
    }
}
