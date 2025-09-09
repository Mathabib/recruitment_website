<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\Jurusan;
use Illuminate\Support\Carbon;

class VacancyController extends Controller
{
    
     public function search(Request $request)
    {
      
        $jobName = $request->input('job_name');
        $employmentType = $request->input('employment_type');
        $workLocation = $request->input('work_location');
        $sort = $request->input('sort', 'asc');  

       
        $jobs = Job::query();

        
        if ($jobName) {
            $jobs->where('job_name', 'like', '%' . $jobName . '%');
        }

        
        if ($employmentType) {
            $jobs->where('employment_type', $employmentType);
        }

        
        if ($workLocation) {
            $jobs->whereHas('workLocation', function($query) use ($workLocation) {
                $query->where('location', 'like', '%' . $workLocation . '%');
            });
        }

        // unpublish tidak akan muncul di tampilan
        $jobs->where('status_published', '!=', 'unpublish');

        
        if ($sort === 'desc') {
            $jobs->orderBy('job_name', 'desc');
        } else {
            $jobs->orderBy('job_name', 'asc');
        }

       
        // $jobs = $jobs->get();
        $jobs = $jobs->paginate(10);

       
        return view('list', compact('jobs'));
    }

    
    
    public function index($id)
    {
        // cari jobs dengan id tertentu
        $jobs = Job::findOrfail($id);
        $work_location = $jobs->workLocation->location; 
        //diatas adalah contoh dari inverse relation child referensi ke parent, kita harus sesuaikan dengan nama model nya
        //nama table nya adalah work_location, tapi nama model nya adalah WorkLocation 
        //maka kita pakai WorkLocation
        if(!$jobs || $jobs->status_published == 0){
            abort(404);
        }
        
        // Kirim data jobs ke view vacancy
        return view('vacancy', compact('jobs', 'work_location'));
    }

   public function showJobDetails(Job $job)
    {
        // Menampilkan detail pekerjaan berdasarkan ID
        return view('detail', compact('job'));
    }
    
    public function list()
    {
        $jobs = Job::all();
        $jobs = Job::where('status_published', 1)->get();
        return view('vacancy_list', compact('jobs'));
    }

    // public function list2()
    // {
    //     $jobs = Job::all();
    //     $jobs = Job::where('status_published', 1)->get();
    //     return view('list', compact('jobs'));
    // }
    
      public function list2(Request $request)
{
    // Paginate the jobs, showing 10 per page, where 'status_published' is 1
    $jobs = Job::where('status_published', 1)
               ->paginate(10); // Paginate results, 10 per page
    
    // Append the current query parameters to preserve filters across pagination
    $jobs->appends($request->all());

    // Return the view with the jobs
    return view('list', compact('jobs'));
}

    public function submit_applicant(Request $request)
    {
        $data = $request;
        return view('test', compact('data'));
    }

    public function form($id)
    {
        $jobs = Job::findOrFail($id);
        $educations = Education::all();

        if(!$jobs || $jobs->status_published == 0){
            abort(404);
        }

        return view('vacancy_form', compact('jobs', 'educations'));
    }

   

    public function kirim(Request $request)
    {
    //    return $request;
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
            'salary_expectation' => 'nullable|min:0',
            'role.*' => 'required|string|max:255',
            'name_company.*' => 'required|string',
            'desc_kerja.*' => 'required|string',
            'mulai.*' => 'required|date',
            // 'selesai.*' => 'required|date',
            'project_name.*' => 'nullable|string|max:255',
            'client.*' => 'nullable|string|max:255',
            'desc_project.*' => 'nullable|string',
            // 'mulai_project.*' => 'nullable|date',
            // 'selesai_project.*' => 'nullable|date',
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
        $jurusan = Jurusan::where('education_id', $educationId)->where('name_jurusan', $request->jurusan)->first();
        if(!$jurusan){
            $jurusan = Jurusan::Create([
                'name_jurusan' => strtolower($request->jurusan),
                'education_id' => $educationId
            ]);
        }
        // $jurusan = $education->Jurusan()->firstOrCreate(['name_jurusan' => $request->jurusan], ['education_id' => $educationId]);
        // $jurusan = Jurusan::firstOrCreate(['name_jurusan' => $request->jurusan], ['education_id' => $educationId]);

         //ubah format salary expectation
        $salary = str_replace('.', '', $request->salary_expectation); // hilangkan titik
        $salary = str_replace(',', '.', $salary); // ubah koma jadi titik (jika ada)
        $salary = (int) $salary;

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
            'salary_expectation' => $salary,
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
                    'selesai' => $request->present[$index] == 'present' ? Carbon::today() : $request->selesai[$index],
                    'present' => $request->present[$index],
                    // 'selesai' => isset($request->present[$index]) ? Carbon::now() : $request->selesai[$index],
                    // 'present' => isset($request->present[$index]) ? 'present' : ''
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
                    // 'mulai_project' => $request->mulai_project[$index],
                    // 'selesai_project' => $request->selesai_project[$index],
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
    
        return redirect()->route('vacancy', $request->job_id)->with('success', 'Your application has been sent');
    }
    
    

    

    public function test(Request $request)
    {
        $data = $request;
        return view('test', compact('data'));
    }


}
