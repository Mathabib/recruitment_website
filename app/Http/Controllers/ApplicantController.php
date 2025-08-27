<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Education;
use App\Models\Job;
use App\Models\Jurusan;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    public function generatePdf($id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return redirect()->route('pipelines.index')->with('error', 'Applicant not found.');
        }

        $pdf = PDF::loadView('pipelines.pdf', ['applicant' => $applicant])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('applicant-cv-' . $applicant->name . '.pdf');
    }


    // public function index(Request $request)
    // {
    //     $query = Applicant::with('job', 'education', 'jurusan');
    //     $type = null;
    //     $query->where('type', $type);

    //     $jobId = $request->get('job_id');
    //     $jobTitle = $jobId ? optional(Job::find($jobId))->job_name : null;
    //     $status = $request->get('status');
    //     $sort = $request->get('sort', 'newest');

    //     if ($jobId) {
    //         $query->where('job_id', $jobId);
    //     }

    //     if ($status) {
    //         $query->where('status', $status);
    //     }
    //     // Filter by current status if exists
    //     $currentStatus = $request->get('status');
    //     if ($currentStatus && $currentStatus !== '') {
    //         $query->where('status', $currentStatus);
    //     }


    //     // Memeriksa jika ada job_id atau status
    //     $applicants = $query->get();


    //     // Ambil stage name jika ada job_id
    //     $stageName = $jobId ? ($applicants->isNotEmpty() ? $applicants->first()->status : null) : null;

    //     if ($jobId || $status) {
    //         // Jika ada job_id, filter data berdasarkan job_id
    //         if ($jobId) {
    //             $query->where('job_id', $jobId);
    //         }


    //         if ($request->has('education') && !empty($request->get('education'))) {
    //             $educationId = $request->get('education');
    //             $query->where('education_id', $educationId);
    //         }

    //         if ($request->has('jurusan') && !empty($request->get('jurusan'))) {
    //             $jurusanId = $request->get('jurusan');
    //             $query->where('jurusan_id', $jurusanId);
    //         }


    //         if ($request->has('recommendation') && $request->get('recommendation') != '') {
    //             $query->where('recommendation_status', $request->get('recommendation'));
    //         }


    //         if ($status && $status != '') {
    //             $query->where('status', $status);
    //         }
    //     } else {
    //         // Jika tidak ada job_id dan status, terapkan filter ke semua data
    //         if ($request->has('status') && $request->get('status') != '') {
    //             $query->where('status', $request->get('status'));
    //         }

    //         if ($request->has('education') && !empty($request->get('education'))) {
    //             $educationId = $request->get('education');
    //             $query->where('education_id', $educationId);
    //         }

    //         if ($request->has('jurusan') && !empty($request->get('jurusan'))) {
    //             $jurusanId = $request->get('jurusan');
    //             $query->where('jurusan_id', $jurusanId);
    //         }

    //         if ($request->has('recommendation') && $request->get('recommendation') != '') {
    //             $query->where('recommendation_status', $request->get('recommendation'));
    //         }
    //     }

    //     // Search 
    //     if ($request->has('search')) {
    //         $search = $request->get('search');

    //         if ($jobId && $status) {
    //             $query->where('name', 'like', $search . '%');
    //         } else {

    //             $query->where(function ($query) use ($search) {
    //                 $query->where('name', 'like', $search . '%')
    //                     ->orWhereHas('job', function ($query) use ($search) {
    //                         $query->where('job_name', 'like', $search . '%');
    //                     });
    //             });
    //         }
    //     }



    //     // Logika penyortiran
    //     if ($jobId && $status) {
    //         // Jika ada job_id dan status, filter berdasarkan job_id dan status
    //         $query->where('job_id', $jobId)
    //               ->where('status', $status);
    //     } else {
    //         // Jika tidak ada job_id dan status, ambil semua data
    //         // Anda bisa mengatur filter tambahan jika diperlukan di sini
    //     }
        
    //     // Sortir data berdasarkan parameter sort
    //     if ($sort === 'newest') {
    //         $query->orderBy('created_at', 'desc');
    //     } elseif ($sort === 'oldest') {
    //         $query->orderBy('created_at', 'asc');
    //     } elseif ($sort === 'a_to_z') {
    //         $query->orderBy('name', 'asc');
    //     } elseif ($sort === 'z_to_a') {
    //         $query->orderBy('name', 'desc');
    //     }
        
    //     // Eksekusi query untuk mendapatkan hasil
    //     $results = $query->get();

        
        
    //     // Pagination
    //     $perPage = 10;
    //     $applicants = $query->paginate($perPage);

    //     // Get the count of applicants based on status
    //     $jobId = $request->input('job_id'); // Assuming you're getting job_id from the request

    //     if ($jobId) {
            
    //         // If job_id exists, filter by job_id
    //         $statusCounts = [
    //             'applied' => Applicant::where('status', 'applied')->where('job_id', $jobId)->count(),
    //             'interview' => Applicant::where('status', 'interview')->where('job_id', $jobId)->count(),
    //             'offer' => Applicant::where('status', 'offer')->where('job_id', $jobId)->count(),
    //             'accepted' => Applicant::where('status', 'accepted')->where('job_id', $jobId)->count(),
    //             'bankcv' => Applicant::where('status', 'bankcv')->where('job_id', $jobId)->count(),
    //         ];
    //     } else {
    //         // If job_id does not exist, count all statuses
    //         $statusCounts = [
    //             'applied' => Applicant::where('status', 'applied')->count(),
    //             'interview' => Applicant::where('status', 'interview')->count(),
    //             'offer' => Applicant::where('status', 'offer')->count(),
    //             'accepted' => Applicant::where('status', 'accepted')->count(),
    //             'bankcv' => Applicant::where('status', 'bankcv')->count(),
    //         ];
    //     }
        


    //     // Load dropdown options
    //     $jobs = Job::all();
    //     $educations = Education::all();
    //     $jurusans = Jurusan::all();

    //     return view('pipelines.index', compact('applicants', 'jobs', 'jobTitle', 'educations', 'jurusans', 'request', 'statusCounts', 'stageName'));
    // }

    public function index(Request $request)
{   
    
    $query = Applicant::with('job', 'education', 'jurusan');


    $pagination = 10;
    if(isset($request['pagination'])){
        $pagination = $request['pagination'];
    }

    $query->whereNull('type');
    $jobId = $request->get('job_id');
    $jobTitle = $jobId ? optional(Job::find($jobId))->job_name : null;
    $status = $request->get('status');
    $sort = $request->get('sort', 'newest');

    if ($jobId) {
        $query->where('job_id', $jobId);
    }

    if ($status) {
        $query->where('status', $status);
    }
    // Filter by current status if exists
    $currentStatus = $request->get('status');
    if ($currentStatus && $currentStatus !== '') {
        $query->where('status', $currentStatus);
    }


    // Memeriksa jika ada job_id atau status
    $applicants = $query->get();


    // Ambil stage name jika ada job_id
    $stageName = $jobId ? ($applicants->isNotEmpty() ? $applicants->first()->status : null) : null;

    if ($jobId || $status) {
        // Jika ada job_id, filter data berdasarkan job_id
        if ($jobId) {
            $query->where('job_id', $jobId);
        }


        if ($request->has('education') && !empty($request->get('education'))) {
            $educationId = $request->get('education');
            $query->where('education_id', $educationId);
        }

        if ($request->has('jurusan') && !empty($request->get('jurusan'))) {
            $jurusanId = $request->get('jurusan');
            $query->where('jurusan_id', $jurusanId);
        }


        if ($request->has('recommendation') && $request->get('recommendation') != '') {
            $query->where('recommendation_status', $request->get('recommendation'));
        }


        if ($status && $status != '') {
            $query->where('status', $status);
        }
    } else {
        // Jika tidak ada job_id dan status, terapkan filter ke semua data
        if ($request->has('status') && $request->get('status') != '') {
            $query->where('status', $request->get('status'));
        }

        if ($request->has('education') && !empty($request->get('education'))) {
            $educationId = $request->get('education');
            $query->where('education_id', $educationId);
        }

        if ($request->has('jurusan') && !empty($request->get('jurusan'))) {
            $jurusanId = $request->get('jurusan');
            $query->where('jurusan_id', $jurusanId);
        }

        if ($request->has('recommendation') && $request->get('recommendation') != '') {
            $query->where('recommendation_status', $request->get('recommendation'));
        }
    }

    // Search 
if ($request->has('search')) {
    $search = $request->get('search');
    $search_by = $request->get('search_by');

    if ($jobId && $status) {
        $query->where('name', 'like', "%{$search}%");
    } else {
        if ($search_by === 'name') {
            // Filter langsung di kolom applicant
            $query->where('name', 'like', "%{$search}%");
        } elseif ($search_by === 'job_name') {
            // Filter di relasi job
            $query->whereHas('job', function ($q) use ($search) {
                $q->where('job_name', 'like', "%{$search}%");
            });
        }
    }
}



    // Logika penyortiran
    if ($jobId && $status) {
        // Jika ada job_id dan status, filter berdasarkan job_id dan status
        $query->where('job_id', $jobId)
              ->where('status', $status);
    } else {
        // Jika tidak ada job_id dan status, ambil semua data
        // Anda bisa mengatur filter tambahan jika diperlukan di sini
    }
    
    // Sortir data berdasarkan parameter sort
    if ($sort === 'newest') {
        $query->orderBy('created_at', 'desc');
    } elseif ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } elseif ($sort === 'a_to_z') {
        $query->orderBy('name', 'asc');
    } elseif ($sort === 'z_to_a') {
        $query->orderBy('name', 'desc');
    }  elseif ($sort === 'name_asc') {
        $query->orderBy('name', 'asc');
    }  elseif ($sort === 'name_desc') {
        $query->orderBy('name', 'desc');
    } elseif ($sort === 'job_asc') {
        $query->orderBy(Job::select('job_name')->whereColumn('jobs.id', 'applicants.job_id'), 'asc');
    } elseif ($sort === 'job_desc') {
        $query->orderBy(Job::select('job_name')->whereColumn('jobs.id', 'applicants.job_id'), 'desc');
    } elseif ($sort === 'education_asc') {
        $query->orderBy(Education::select('name_education')->whereColumn('education.id', 'applicants.education_id'), 'asc');
    } elseif ($sort === 'education_desc') {
        $query->orderBy(Education::select('name_education')->whereColumn('education.id', 'applicants.education_id'), 'desc');
    } 
        
    // Eksekusi query untuk mendapatkan hasil
    $results = $query->get();

    // Pagination
    $perPage = 20;
    // $applicants = $query->paginate($perPage);
    if ($pagination == 'all'){
        $applicant = $query->get();
    } else {
        $applicants = $query->paginate($pagination)->appends($request->all());
    }
    
    

    // Get the count of applicants based on status
    $jobId = $request->input('job_id'); // Assuming you're getting job_id from the request

    if ($jobId) {
        
        // If job_id exists, filter by job_id
        $statusCounts = [
            'applied' => Applicant::where('status', 'applied')->where('job_id', $jobId)->count(),
            'interview' => Applicant::where('status', 'interview')->where('job_id', $jobId)->count(),
            'offer' => Applicant::where('status', 'offer')->where('job_id', $jobId)->count(),
            'accepted' => Applicant::where('status', 'accepted')->where('job_id', $jobId)->count(),
            'bankcv' => Applicant::where('status', 'bankcv')->where('job_id', $jobId)->count(),
        ];
    } else {
        // If job_id does not exist, count all statuses
        $statusCounts = [
            'applied' => Applicant::where('status', 'applied')->count(),
            'interview' => Applicant::where('status', 'interview')->count(),
            'offer' => Applicant::where('status', 'offer')->count(),
            'accepted' => Applicant::where('status', 'accepted')->count(),
            'bankcv' => Applicant::where('status', 'bankcv')->count(),
        ];
    }
    


    // Load dropdown options
    $jobs = Job::all();
    $educations = Education::all();
    $jurusans = Jurusan::all();
    // $applicants = Applicant::where('type', 'resindo')
    // ->paginate(10);  // Tentukan jumlah data per halaman, misalnya 10

    return view('pipelines.index', compact('applicants', 'jobs', 'jobTitle', 'educations', 'jurusans', 'request', 'statusCounts', 'stageName'));
}










    public function getJurusan($education_id)
    {
        $jurusans = Jurusan::where('education_id', $education_id)->get();
        return response()->json($jurusans);
    }

    public function create()
    {
        $jobs = Job::all();
        $educations = Education::all();
        $jurusans = Jurusan::all();


        return view('pipelines.create', compact('jobs', 'educations', 'jurusans'));
    }




    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'number' => 'required|string|max:15',
            'email' => 'required|email',
            'profil_linkedin' => 'nullable|url',
            'certificates.*' => 'nullable|string',
            'experience_period' => 'nullable|string',
            'photo_pass' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile' => 'nullable|string',
            'languages' => 'nullable|string',
            'mbti' => 'nullable|string',
            'iq' => 'nullable|string',
            'achievements.*' => 'nullable|string',
            'skills.*' => 'nullable|string',
            'salary_expectation' => 'required|numeric|min:0',
            'role.*' => 'required|string|max:255',
            'name_company.*' => 'required|string',
            'desc_kerja.*' => 'required|string',
            'mulai.*' => 'required|date',
            'selesai.*' => 'required|date',
            'project_name.*' => 'nullable|string|max:255',
            'client.*' => 'nullable|string|max:255',
            'desc_project.*' => 'nullable|string',
            'mulai_project.*' => 'nullable|date',
            'selesai_project.*' => 'nullable|date',
            'name_ref.*' => 'nullable|string|max:255',
            'phone.*' => 'nullable|string|max:255',
            'email_ref.*' => 'nullable|string',
            'education' => 'required|exists:education,id',
            'jurusan' => 'required|string|max:255', // Atur sesuai kebutuhan
        ]);

        // Handle file upload for photo_pass if provided
        $path = null;
        if ($request->hasFile('photo_pass')) {
            $path = $request->file('photo_pass')->store('photos', 'public');
        }
        $educationId = $request->education;
        // Cek dan simpan jurusan
        $jurusan = Jurusan::firstOrCreate(['name_jurusan' => $request->jurusan], ['education_id' => $educationId]);

        // Create applicant
        $applicant = Applicant::create([
            'job_id' => $request->job_id,
            'name' => $request->name,
            'address' => $request->address,
            'number' => $request->number,
            'email' => $request->email,
            'profil_linkedin' => $request->profil_linkedin,
            'certificates' => implode("|", $request->certificates ?? []),
            'experience_period' => $request->experience_period,
            'photo_pass' => $path,
            'profile' => $request->profile,
            'languages' => $request->languages,
            'mbti' => $request->mbti,
            'iq' => $request->iq,
            'achievement' => implode("|", $request->achievements ?? []),
            'skills' => implode("|", $request->skills ?? []),
            'salary_expectation' => $request->salary_expectation,
            'education_id' => $request->education, // Pastikan ini mengacu ke id yang benar
            'jurusan_id' => $jurusan->id, // Gunakan ID dari jurusan
        ]);

        // Handle work experiences
        if ($request->has('role')) {
            foreach ($request->role as $index => $role) {
                $applicant->workExperiences()->create([
                    'role' => $role,
                    'name_company' => $request->name_company[$index],
                    'desc_kerja' => $request->desc_kerja[$index],
                    'mulai' => $request->mulai[$index],
                    'selesai' => $request->selesai[$index],
                ]);
            }
        }

        // Handle projects
        if ($request->has('project_name')) {
            foreach ($request->project_name as $index => $project_name) {
                $applicant->projects()->create([
                    'project_name' => $project_name,
                    'desc_project' => $request->desc_project[$index],
                    'client' => $request->client[$index],
                    'mulai_project' => $request->mulai_project[$index],
                    'selesai_project' => $request->selesai_project[$index],
                ]);
            }
        }

        // Handle references
        if ($request->has('name_ref')) {
            foreach ($request->name_ref as $index => $name_ref) {
                $applicant->references()->create([
                    'name_ref' => $name_ref,
                    'phone' => $request->phone[$index],
                    'email_ref' => $request->email_ref[$index],
                ]);
            }
        }

        $applicant->Notes()->create([
            'notes' => ''
        ]);


        return redirect()->route('pipelines.index')->with('success', 'Applicant created successfully.');
    }


    public function edit($id)
    {
        $applicant = Applicant::with(['workExperiences', 'projects', 'references'])->findOrFail($id);
        $jobs = Job::all();
        $educations = Education::all();
        $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();
        $references = Reference::all();
        $project = Project::all();



        return view('pipelines.edit', compact('applicant', 'jobs', 'educations', 'jurusans'));
    }

    public function edit_api($id)
    {
        $applicant = Applicant::with(['workExperiences', 'projects', 'references'])->findOrFail($id);
        $jobs = Job::all();
        $educations = Education::all();
        $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();

        return json_encode($applicant);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        // Validate input
        //khusus validate yang sifatnya array maka harus ditambahkan '.*' setelah nama atribut $requestnya 
        //misal 'skills.*' => 'nullable|string',
        //kalau gak dia bakal refresh refresh terus di form dan gak kemana mana 
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'number' => 'required|string|max:15',
            'email' => 'required|email',
            'profil_linkedin' => 'nullable|url',
            'certificates.*' => 'nullable|string',
            'experience_period' => 'nullable|string',
            'photo_pass' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile' => 'nullable|string',
            'languages' => 'nullable|string',
            'mbti' => 'nullable|string',
            'iq' => 'nullable|string',
            'achievements.*' => 'nullable|string',
            'skills.*' => 'nullable|string',
            'salary_expectation' => 'required|numeric|min:0',

            'role.*' => 'required|string|max:255',
            'desc_kerja.*' => 'required|string',
            'name_company.*' => 'required|string',
            'mulai.*' => 'required|date',
            'selesai.*' => 'required|date',

            'project_name.*' => 'nullable|string|max:255',
            'client.*' => 'nullable|string|max:255',
            'desc_project.*' => 'nullable|string',
            'mulai_project.*' => 'nullable|date',
            'selesai_project.*' => 'nullable|date',

            'name_ref.*' => 'nullable|string|max:255',
            'phone.*' => 'nullable|string|max:255',
            'email_ref.*' => 'nullable|string',

            'education' => 'required|exists:education,id',
            'jurusan' => 'nullable|string|max:255',
        ]);

        // Retrieve the applicant
        $applicant = Applicant::findOrFail($id);

        if ($applicant->jurusan) {
            $applicant->jurusan->update([
                'name_jurusan' => $request->jurusan
            ]);
        } else {
            // Jika tidak ada, buat data jurusan baru
            $newJurusan = Jurusan::create([
                'name_jurusan' => $request->jurusan
            ]);
            $applicant->jurusan_id = $newJurusan->id;
            $applicant->save();
        }

        // Handle file upload for photo_pass if provided
        if ($request->hasFile('photo_pass')) {
            Storage::disk('public')->delete($applicant->photo_pass);
            $path = $request->file('photo_pass')->store('photos', 'public');
            $applicant->update(['photo_pass' => $path]);
        }

        // Update applicant data
        $applicant->update([
            'job_id' => $request->job_id,
            'name' => $request->name,
            'address' => $request->address,
            'number' => $request->number,
            'email' => $request->email,
            'profil_linkedin' => $request->profil_linkedin,
            'certificates' => implode("|", $request->certificates),
            'experience_period' => $request->experience_period,
            'profile' => $request->profile,
            'languages' => $request->languages,
            'mbti' => $request->mbti,
            'iq' => $request->iq,
            'achievement' => implode("|", $request->achievements),
            'skills' => implode("|", $request->skills),
            'salary_expectation' => $request->salary_expectation,
            'education_id' => $request->education,
            // 'jurusan_id' => $request->jurusan,
        ]);

        // Update or create work experiences
        $applicant->workExperiences()->delete(); // Delete previous work experiences
        if ($request->has('role')) {
            foreach ($request->role as $index => $role) {
                $applicant->workExperiences()->create([
                    'role' => $role,
                    'desc_kerja' => $request->desc_kerja[$index],
                    'name_company' => $request->name_company[$index],
                    'mulai' => $request->mulai[$index],
                    'selesai' => $request->selesai[$index],
                ]);
            }
        }

        // Update or create projects
        $applicant->projects()->delete(); // Delete previous projects
        if ($request->has('project_name')) {
            foreach ($request->project_name as $index => $project_name) {
                $applicant->projects()->create([
                    'project_name' => $project_name,
                    'desc_project' => $request->desc_project[$index],
                    'client' => $request->client[$index],
                    'mulai_project' => $request->mulai_project[$index],
                    'selesai_project' => $request->selesai_project[$index],
                ]);
            }
        }

        // Update or create references
        $applicant->references()->delete(); // Delete previous references
        if ($request->has('name_ref')) {
            foreach ($request->name_ref as $index => $name_ref) {
                $applicant->references()->create([
                    'name_ref' => $name_ref,
                    'phone' => $request->phone[$index],
                    'email_ref' => $request->email_ref[$index],
                ]);
            }
        }

        return redirect()->route('pipelines.index')->with('success', 'Applicant updated successfully.');
    }


    public function destroy($id)
    {
        $applicant = Applicant::find($id);       
        if ($applicant) {
            Storage::disk('public')->delete($applicant->photo_pass);
            $applicant->delete();
        }        
        return redirect()->route('pipelines.index')->with('success_message', 'Applicant deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $applicant = Applicant::findOrFail($id);
        $applicant->status = $request->status;
        $applicant->save();

        return redirect()->back()->with('success', 'Applicant status updated successfully!');
    }

    public function show($jobId)
    {
        // Get the job title
        $job = Job::find($jobId);
        $jobTitle = $job ? $job->job_name : null;

        // Get applicants for this job
        $applicants = Applicant::where('job_id', $jobId)->get();

        // Get the stage name for the first applicant (or however you want to decide)
        $stageName = $applicants->isNotEmpty() ? $applicants->first()->status : null;

        return view('jobs.show', compact('applicants', 'jobTitle', 'stageName'));
    }

    public function getNotes($id)
    {
        $notes = Notes::where('applicant_id', $id)->first();
        return response()->json($notes);
    }
    public function saveNotes(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'notes' => 'required|string',
        ]);

        // Simpan atau update notes di table
        // DB::table('notes')->updateOrInsert(
        //     ['applicant_id' => $request->applicant_id], 
        //     ['notes' => $request->notes, 'updated_at' => now()]
        // );

        $note = notes::where('applicant_id', $request->applicant_id)->first();
        $applicant = Applicant::findOrFail($request->applicant_id);
        if ($note) {
            $note->update([
                'notes' => $request->notes
            ]);
        } else {
            $applicant->notes()->create([
                'notes' => $request->notes
            ]);
        }





        return response()->json(['message' => 'Notes saved successfully!']);
    }

    public function deleteNotes(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
        ]);

        // DB::table('notes')->where('applicant_id', $request->applicant_id)->delete();
        $note = notes::where('applicant_id', $request->applicant_id)->first();
        $note->update([
            'notes' => ''
        ]);

        return response()->json(['message' => 'Notes deleted successfully!']);
    }

    public function updateRecommendation(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'recommendation_status' => 'required|string',
            'id' => 'required|integer|exists:applicants,id',
        ]);

        // Temukan applicant berdasarkan ID
        $applicant = Applicant::find($validatedData['id']);

        // Perbarui status rekomendasi
        $applicant->recommendation_status = $validatedData['recommendation_status'];
        $applicant->save();

        return response()->json(['message' => 'Status rekomendasi berhasil diperbarui!']);
    }


}