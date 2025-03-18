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
use Barryvdh\DomPDF\Facade\Pdf;


class ResindoController extends Controller
{

    public function generateCV($id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return redirect()->route('pipelines-resindo.index')->with('error', 'Applicant not found.');
        }

        $pdf = PDF::loadView('pipelines-resindo.pdf', ['applicant' => $applicant])
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
        $request->validate([
            'job_id' => 'nullable|exists:jobs,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'number' => 'required|string|max:15',
            'email' => 'nullable|email',
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
            'salary_expectation' => 'nullable|numeric|min:0',
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
            'jurusan' => 'required|string|max:255',
        ]);
    
        // Menangani upload file photo_pass jika ada
        $path = null;
        if ($request->hasFile('photo_pass')) {
            $path = $request->file('photo_pass')->store('photos', 'public');
        }
    
        $educationId = $request->education;
        
        // Cek dan simpan jurusan
        $jurusan = Jurusan::where('education_id', $educationId)->where('name_jurusan', $request->jurusan)->first();
        if(!$jurusan){
            $jurusan = Jurusan::Create([
                'name_jurusan' => strtolower($request->jurusan),
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
            'education_id' => $request->education,
            'jurusan_id' => $jurusan->id,
            'type' => 'resindo',
        ]);
    
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
                    'selesai' => $request->selesai[$index],
                ]);
            }
        }
    
        // Menangani proyek
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
        }
        
        // Eksekusi query untuk mendapatkan hasil
        $results = $query->get();
    
        // Pagination
        $perPage = 10;
        $applicants = $query->paginate($perPage);
    
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
        $request->validate([
            'job_id' => 'nullable|exists:jobs,id',
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
            'salary_expectation' => 'nullable|numeric|min:0',
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
            'jurusan' => 'required|string|max:255',
        ]);
    
        // Menangani upload file photo_pass jika ada
        $path = null;
        if ($request->hasFile('photo_pass')) {
            $path = $request->file('photo_pass')->store('photos', 'public');
        }
    
        $educationId = $request->education;
        
        // Cek dan simpan jurusan
        $jurusan = Jurusan::where('education_id', $educationId)->where('name_jurusan', $request->jurusan)->first();
        if(!$jurusan){
            $jurusan = Jurusan::Create([
                'name_jurusan' => strtolower($request->jurusan),
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
            'education_id' => $request->education,
            'jurusan_id' => $jurusan->id,
            'type' => 'resindo',
        ]);
    
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
                    'selesai' => $request->selesai[$index],
                ]);
            }
        }
    
        // Menangani proyek
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
        $applicant = Applicant::with(['workExperiences', 'projects', 'references'])->findOrFail($id);
        $jobs = Job::all();
        $educations = Education::all();
        $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();
        $references = Reference::all();
        $project = Project::all();



        return view('pipelines-resindo.edit', compact('applicant', 'jobs', 'educations', 'jurusans'));
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
        $request->validate([            
        //    'job_id' => 'nullable|exists:jobs,id',
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
            'salary_expectation' => 'nullable|numeric|min:0',
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
            'education_id' => $request->education, // Pastikan ini mengacu
            'jurusan_id' => $jurusan->id, // Gunakan ID dari jurusan
            'type' => 'resindo',
        ]);

        dd($applicant);

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
