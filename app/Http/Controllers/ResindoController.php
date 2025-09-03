<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\Reference;
use App\Models\Project;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;
use App\Models\Jurusan;
use App\Models\Jurusan2;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;


class ResindoController extends Controller
{

    public function generateCV($id)
    {
        $applicant = Applicant::find($id);
        // return  $applicant->workExperience;
        // return $applicant->job->job_name;

        if (!$applicant) {
            return redirect()->route('pipelines-resindo.index')->with('error', 'Applicant not found.');
        }

        $pdf = PDF::loadView('pipelines-resindo.pdf', ['applicant' => $applicant,
        'position' => isset($applicant->workExperiences[0]->role) ? $applicant->workExperiences[0]->role : 'none'])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('applicant-cv-' . $applicant->name . '.pdf');
    }

    public function generateSummary($id)
    {
        $applicant = Applicant::find($id);              
        if (!$applicant) {
            return redirect()->route('pipelines-resindo.index')->with('error', 'Applicant not found.');
        }

        $pdf = PDF::loadView('pipelines-resindo.summary', ['applicant' => $applicant])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('applicant-summary-' . $applicant->name . '.pdf');
    }



    public function formresindo()
    {
        $jobs = Job::all();
        $educations = Education::all();

      
        return view('form-resindo', compact('jobs', 'educations'));
    }
    
    public function kirimresindo(Request $request)
    {
        
        // Validasi input
        return $request;
        $request->validate([
            'job_id' => 'nullable|exists:jobs,id',
            'name' => 'required|string|max:255',
            // 'address' => 'required|string',
            // 'number' => 'required|string|max:15',
            // 'email' => 'nullable|email',
            // 'profil_linkedin' => 'nullable|url',
            'certificates.*' => 'nullable|string',
            'experience_period' => 'nullable|string',
            'photo_pass' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile' => 'nullable|string',
            'languages' => 'nullable|string',
            'mbti' => 'nullable|string',
            'iq' => 'nullable|string',
            'achievements.*' => 'nullable|string',
            'skills.*' => 'nullable|string',
            // 'salary_expectation' => 'nullable|numeric|min:0',
            'role.*' => 'nullable|string|max:255',
            'name_company.*' => 'nullable|string',
            'desc_kerja.*' => 'nullable|string',
            'mulai.*' => 'nullable|date',
            'selesai.*' => 'nullable|date',
            'project_name.*' => 'nullable|string|max:255',
            'client.*' => 'nullable|string|max:255',
            'position.*' => 'nullable|string|max:255',
            'location.*' => 'nullable|string|max:255',
            // 'desc_project.*' => 'nullable|string',
            // 'mulai_project.*' => 'nullable|date',
            // 'selesai_project.*' => 'nullable|date',
            'name_ref.*' => 'nullable|string|max:255',
            'phone.*' => 'nullable|string|max:255',
            'email_ref.*' => 'nullable|string',
            'education*' => 'nullable|exists:education,id',
            'jurusan*' => 'nullable|string|max:255',
            'present*' => 'nullable|string|max:255'
        ]);
        // return $request;
        // return $request;
        // Menangani upload file photo_pass jika ada
        $path = null;
        if ($request->hasFile('photo_pass')) {
            $path = $request->file('photo_pass')->store('photos', 'public');
        }
    
        $educationId = $request->education[0];
        
        // Cek dan simpan jurusan
        $jurusan = Jurusan::where('education_id', $educationId)->where('name_jurusan', $request->jurusan[0])->first();
        if(!$jurusan){
            $jurusan = Jurusan::Create([
                'name_jurusan' => strtolower($request->jurusan[0]),
                'education_id' => $educationId
            ]);
        }

        

        
    
        // Simpan data applicant
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
            'education_id' => $request->education[0],
            'jurusan_id' => $jurusan->id,
            'type' => 'resindo',
        ]);

        
        foreach($request->jurusan as $index => $jurusan) {
            Jurusan2::create([
                'jurusan2' => strtolower($request->jurusan[$index]),
                'education_id' => $request->education[$index],
                'applicant_id' => $applicant->id,
            ]);
        }
    
        // Menangani bahasa (language)
        if ($request->has('language')) {
            foreach ($request->language as $index => $language) {
                // Menyimpan data ke tabel language yang berelasi dengan applicant_id
                $applicant->languages()->create([
                    'language' => $language,
                    'verbal' => $request->verbal[$index],
                    'writen' => $request->writen[$index],
                ]);
            }
        }
    
        // Menangani pengalaman kerja
        if ($request->has('role')) {
            foreach ($request->role as $index => $role) {
                $applicant->workExperiences()->create([
                    'role' => $role,
                    'name_company' => $request->name_company[$index],
                    'desc_kerja' => $request->desc_kerja[$index],
                    'mulai' => $request->mulai[$index],
                    'selesai' => $request->present[$index] == 'present' ? Carbon::now() : $request->selesai[$index],
                    'present' => $request->present[$index],
                ]);
            }
        }
    
        // Menangani proyek
        if ($request->has('project_name')) {
            foreach ($request->project_name as $index => $project_name) {
                $applicant->projects()->create([
                    'project_name' => $project_name,
                    // 'desc_project' => $request->desc_project[$index],
                    'client' => $request->client[$index],
                    'position' => $request->position[$index],
                    'location' => $request->location[$index],
                    // 'mulai_project' => $request->mulai_project[$index],
                    // 'selesai_project' => $request->selesai_project[$index],
                ]);
            }
        }
    
        // Menangani referensi
        if ($request->has('name_ref')) {
            foreach ($request->name_ref as $index => $name_ref) {
                $applicant->references()->create([
                    'name_ref' => $name_ref,
                    'phone' => $request->phone[$index],
                    'email_ref' => $request->email_ref[$index],
                ]);
            }
        }
    
        return redirect()->route('form-resindo', $request->job_id)->with('success', 'Your application has been sent');
    }
    
    
    public function indexresindo(Request $request)
    {   
        
        $query = Applicant::with('job', 'education', 'jurusan');
    
        $pagination = 10;
        if(isset($request['pagination'])){
            $pagination = $request['pagination'];
        }
        
        $query->where('type',  'resindo');
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
    
            if ($jobId && $status) {
                $query->where('name', 'like', $search . '%');
            } else {
    
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', $search . '%')
                        ->orWhereHas('job', function ($query) use ($search) {
                            $query->where('job_name', 'like', $search . '%');
                        });
                });
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
        // $perPage = 10;
        // pagination dibawah ini akan membawa format jumlah pagination yang sama pada setiap tombol pagination nya 
        // misal kita seting paginationnya 10, maka kalau kita pencet lagi pagination selanjutnya, akan menampilkan 10 data juga
        // berbeda ketika kita cuman menggunakan paginate(jumlah_pagination) aja , paginate selanjutnya bakal balik lagi ke jumlah default
        // $applicants = $query->paginate($pagination)->appends($request->all());
        if ($pagination == 'all'){
            $applicant = $query->get();
        } else {
            $applicants = $query->paginate($pagination)->appends($request->all());
        }
        // return $applicants;
    
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
        
        return view('pipelines-resindo.index', compact('applicants', 'jobs', 'jobTitle', 'educations', 'jurusans', 'request', 'statusCounts', 'stageName'));
    }

    public function create()
    {
        $jobs = Job::all();
        $educations = Education::all();
        $jurusans = Jurusan::all();


        return view('pipelines-resindo.create', compact('jobs', 'educations', 'jurusans'));
    }


    public function store(Request $request)
    {
        
        // Validasi input
        // return $request;
        $request->validate([
            'job_id' => 'nullable|exists:jobs,id',
            'name' => 'required|string|max:255',
            // 'address' => 'required|string',
            // 'number' => 'required|string|max:15',
            // 'email' => 'nullable|email',
            // 'profil_linkedin' => 'nullable|url',
            'certificates.*' => 'nullable|string',
            'experience_period' => 'nullable|string',
            'photo_pass' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile' => 'nullable|string',
            'languages' => 'nullable|string',
            'mbti' => 'nullable|string',
            'iq' => 'nullable|string',
            'achievements.*' => 'nullable|string',
            'skills.*' => 'nullable|string',
            // 'salary_expectation' => 'nullable|numeric|min:0',
            'role.*' => 'nullable|string|max:255',
            'name_company.*' => 'nullable|string',
            'desc_kerja.*' => 'nullable|string',
            'mulai.*' => 'nullable|date',
            'selesai.*' => 'nullable|date',
            'project_name.*' => 'nullable|string|max:255',
            'client.*' => 'nullable|string|max:255',
            'position.*' => 'nullable|string|max:255',
            'location.*' => 'nullable|string|max:255',
            // 'desc_project.*' => 'nullable|string',
            // 'mulai_project.*' => 'nullable|date',
            // 'selesai_project.*' => 'nullable|date',
            'name_ref.*' => 'nullable|string|max:255',
            'phone.*' => 'nullable|string|max:255',
            'email_ref.*' => 'nullable|string',
            'education*' => 'nullable|exists:education,id',
            'jurusan*' => 'nullable|string|max:255',
            'present*' => 'nullable|string|max:255'
        ]);
        // return $request;
        // return $request;
        // Menangani upload file photo_pass jika ada
        $path = null;
        if ($request->hasFile('photo_pass')) {
            $path = $request->file('photo_pass')->store('photos', 'public');
        }
    
        $educationId = $request->education[0];
        
        // Cek dan simpan jurusan
        $jurusan = Jurusan::where('education_id', $educationId)->where('name_jurusan', $request->jurusan[0])->first();
        if(!$jurusan){
            $jurusan = Jurusan::Create([
                'name_jurusan' => strtolower($request->jurusan[0]),
                'education_id' => $educationId
            ]);
        }

        

        
    
        // Simpan data applicant
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
            'education_id' => $request->education[0],
            'jurusan_id' => $jurusan->id,
            'type' => 'resindo',
        ]);

        
        foreach($request->jurusan as $index => $jurusan) {
            Jurusan2::create([
                'jurusan2' => strtolower($request->jurusan[$index]),
                'education_id' => $request->education[$index],
                'applicant_id' => $applicant->id,
            ]);
        }
    
        // Menangani bahasa (language)
        if ($request->has('language')) {
            foreach ($request->language as $index => $language) {
                // Menyimpan data ke tabel language yang berelasi dengan applicant_id
                $applicant->languages()->create([
                    'language' => $language,
                    'verbal' => $request->verbal[$index],
                    'writen' => $request->writen[$index],
                ]);
            }
        }
    
        // Menangani pengalaman kerja
        if ($request->has('role')) {
            foreach ($request->role as $index => $role) {
                $applicant->workExperiences()->create([
                    'role' => $role,
                    'name_company' => $request->name_company[$index],
                    'desc_kerja' => $request->desc_kerja[$index],
                    'mulai' => $request->mulai[$index],
                    'selesai' => $request->present[$index] == 'present' ? Carbon::now() : $request->selesai[$index],
                    'present' => $request->present[$index],
                ]);
            }
        }
    
        // Menangani proyek
        if ($request->has('project_name')) {
            foreach ($request->project_name as $index => $project_name) {
                $applicant->projects()->create([
                    'project_name' => $project_name,
                    // 'desc_project' => $request->desc_project[$index],
                    'client' => $request->client[$index],
                    'position' => $request->position[$index],
                    'location' => $request->location[$index],
                    // 'mulai_project' => $request->mulai_project[$index],
                    // 'selesai_project' => $request->selesai_project[$index],
                ]);
            }
        }
    
        // Menangani referensi
        if ($request->has('name_ref')) {
            foreach ($request->name_ref as $index => $name_ref) {
                $applicant->references()->create([
                    'name_ref' => $name_ref,
                    'phone' => $request->phone[$index],
                    'email_ref' => $request->email_ref[$index],
                ]);
            }
        }
    
        return redirect()->route('pipelines-resindo.index', $request->job_id)->with('success', 'Your application has been sent');
    }
    
    public function edit($id)
    {
        $applicant = Applicant::find($id);        
        $applicant = Applicant::with(['workExperiences', 'projects', 'references', 'languages'])->findOrFail($id);
        $jobs = Job::all();
        $educations = Education::all();
        // $jobs = Language::all();
        $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();
        $references = Reference::all();
        $project = Project::all();


        // return $applicant->workExperiences;
        return view('pipelines-resindo.edit', compact('applicant', 'jobs', 'educations', 'jurusans'));
    }

    public function edit_api($id)
    {
        $applicant = Applicant::with(['workExperiences', 'projects', 'references', 'languages', 'jurusan2'])->findOrFail($id);
        $jobs = Job::all();
        $language = Language::all();
        $educations = Education::all();
        $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();

        return json_encode([
            'applicant' => $applicant,
            'educations' => $educations
        ]);
    }

    public function update(Request $request, $id)
    {
        // return $request->jurusan[0]; 
                  
        $request->validate([            
           'job_id' => 'nullable|exists:jobs,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            // 'number' => 'nullable|string|max:15',
            // 'email' => 'nullable|email',
            // 'profil_linkedin' => 'nullable|url',
            'certificates.*' => 'nullable|string',
            'experience_period' => 'nullable|string',
            'photo_pass' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile' => 'nullable|string',
            'languages' => 'nullable|string',
            'mbti' => 'nullable|string',
            'iq' => 'nullable|string',
            'achievements.*' => 'nullable|string',
            'skills.*' => 'nullable|string',
            'salary_expectation' => 'nullable|numeric|min:0',
            'role.*' => 'nullable|string|max:255',
            'name_company.*' => 'nullable|string',
            'desc_kerja.*' => 'nullable|string',
            'mulai.*' => 'nullable|date',
            'selesai.*' => 'nullable|date',
            'project_name.*' => 'nullable|string|max:255',
            'client.*' => 'nullable|string|max:255',
            'position.*' => 'nullable|string|max:255',
            'location.*' => 'nullable|string|max:255',
            // 'desc_project.*' => 'nullable|string',
            // 'mulai_project.*' => 'nullable|date',
            // 'selesai_project.*' => 'nullable|date',
            'name_ref.*' => 'nullable|string|max:255',
            'phone.*' => 'nullable|string|max:255',
            'email_ref.*' => 'nullable|string',
            'education*' => 'nullable|exists:education,id',
            'jurusan*' => 'nullable|string|max:255', // Atur sesuai kebutuhan
            
        ]);

        // Retrieve the applicant                
        $applicant = Applicant::findOrFail($id);         
        if ($request->jurusan[0] != $applicant->jurusan->name_jurusan) {
            $applicant->jurusan->update([
                'name_jurusan' => $request->jurusan[0],
                'education_id' => $request->education[0]
            ]);
            
        }
        $applicant->jurusan2()->delete();
        foreach($request->education as $index => $item){
            $applicant->jurusan2()->create([
                'education_id' => $request->education[$index],
                'jurusan2' => $request->jurusan[$index]
            ]);
        }


        // Handle file upload for photo_pass if provided
        if ($request->hasFile('photo_pass')) {
            Storage::disk('public')->delete($applicant->photo_pass);
            $path = $request->file('photo_pass')->store('photos', 'public');
            $applicant->update(['photo_pass' => $path]);
        }else{
            $path = $applicant->photo_pass;
        }

        // Update applicant data
        $applicant->update([
            // 'job_id' => $request->job_id,
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
            'type' => 'resindo',
            'job_id' => $request->job_id
        ]);

        $applicant->languages()->delete();
        if ($request->has('language')) {
            foreach ($request->language as $index => $language) {
                // Menyimpan data ke tabel language yang berelasi dengan applicant_id
                $applicant->languages()->create([
                    'language' => $language,
                    'verbal' => $request->verbal[$index],
                    'writen' => $request->writen[$index],
                ]);
            }
        }
        
        // Update or create work experiences
        $applicant->workExperiences()->delete(); // Delete previous work experiences
        if ($request->has('role')) {
            foreach ($request->role as $index => $role) {
                $applicant->workExperiences()->create([
                    'role' => $role,
                    'desc_kerja' =>  preg_replace('/\s*/u', '', $request->desc_kerja[$index]),
                    'name_company' => $request->name_company[$index],
                    'mulai' => $request->mulai[$index],
                    'selesai' => $request->selesai[$index],
                    'selesai' => $request->selesai[$index],
                    'present' => $request->present[$index]
                ]);
            }
        }

        // Update or create projects
        $applicant->projects()->delete(); // Delete previous projects
        if ($request->has('project_name')) {
            foreach ($request->project_name as $index => $project_name) {
                $applicant->projects()->create([
                    'project_name' => $project_name,
                    // 'desc_project' => $request->desc_project[$index],
                    'client' => $request->client[$index],
                    'position' => $request->position[$index],
                    'location' => $request->location[$index],
                    // 'mulai_project' => $request->mulai_project[$index],
                    // 'selesai_project' => $request->selesai_project[$index],
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

        return redirect()->route('pipelines-resindo.index')->with('success', 'Applicant updated successfully.');
    }

    public function destroy($id)
    {
        $applicant = Applicant::find($id);       
        if ($applicant) {
            Storage::disk('public')->delete($applicant->photo_pass);
            $applicant->delete();
        }        
        return redirect()->route('pipelines-resindo.index')->with('success_message', 'Applicant deleted successfully.');
    }

}
