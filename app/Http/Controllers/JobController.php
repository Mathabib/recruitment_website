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
        // Mulai query dari Model Job
        $query = ModelsJob::query();

        // Filter berdasarkan kata kunci pencarian jika ada
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('job_name', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan department jika ada
        if ($request->has('department')) {
            $departmentId = $request->get('department');
            $query->where('department', $departmentId);
        }

        // Ambil semua data setelah filter
        $jobs = $query->get();

        // Kirim data ke view
        return view('jobs.index', compact('jobs'));
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
            'minimum_salary' => 'required|numeric',
            'maximum_salary' => 'required|numeric',
            'benefit' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'spesifikasi' => 'nullable|string',

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

        // Ambil data work_location dan departement jika ingin ditampilkan dalam dropdown
        $work_locations = WorkLocation::all();
        $departments = Departement::all();

        // Tampilkan halaman edit dengan data job
        return view('jobs.edit', compact('job', 'work_locations', 'departments'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'job_name' => 'required|string|max:255',
            'work_location_id' => 'required|exists:work_location,id', // Validasi bahwa work_location_id ada
            'department' => 'required|exists:departements,id',
            'employment_type' => 'required|string',
            'minimum_salary' => 'required|numeric',
            'maximum_salary' => 'required|numeric',
            'benefit' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
        ]);

        // Cari job berdasarkan ID
        $job = ModelsJob::findOrFail($id);

        // Update data job
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
