<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\Education;
use App\Models\Job;
use App\Models\Jurusan;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Notes;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ApplicantPageController extends Controller
{
    public function index(){
        return view('applicants_page.home');
    }
    public function jobs()
    {
        // $job = Job::find(4);
        // return $job;
        // return $job->getApplicant->count();

        $user = Auth::user();
        $jobs = Job::paginate(10);
        return view('applicants_page.index', compact('user', 'jobs'));
    }
    public function jobsShow($id){
        $job = Job::find($id);
        return view('applicants_page.show', compact('job'));
    }

    public function profile(){
        $applicant = Auth::user()->applicant;
        return view('applicants_page.profile', compact('applicant'));
    }

    public function edit()
    {
        $applicant = Auth::user()->applicant;
        $jobs = Job::all();
        $salary_expectation = number_format(optional($applicant)->salary_expectation, 0, ',', '.');
        $salary_current = number_format(optional($applicant)->salary_current, 0, ',', '.');

        $educations = Education::all();
        $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();
        $references = Reference::all();
        $project = Project::all();
        return view('applicants_page.edit', compact('applicant', 'jobs', 'educations', 'jurusans', 'salary_expectation','salary_current'));
    }

    public function edit_api($id)
    {

        $applicant = Applicant::with(['workExperiences', 'projects', 'references'])->where('id', $id)->firstOrFail();
        // $jobs = Job::all();
        // $educations = Education::all();
        // $jurusans = Jurusan::where('education_id', $applicant->education_id)->get();

        return json_encode($applicant);
    }

    public function update(Request $request)
    {
        // return $request;
        // return $request;
        // dd($request->all());

        // Validate input
        //khusus validate yang sifatnya array maka harus ditambahkan '.*' setelah nama atribut $requestnya
        //misal 'skills.*' => 'nullable|string',
        //kalau gak dia bakal refresh refresh terus di form dan gak kemana mana
        // $request->validate([
        //     'job_id' => 'required|exists:jobs,id',
        //     'name' => 'required|string|max:255',
        //     'address' => 'nullable|string',
        //     'number' => 'nullable|string',
        //     'email' => 'nullable|email',
        //     'profil_linkedin' => 'nullable|url',
        //     'certificates.*' => 'nullable|string',
        //     'experience_period' => 'nullable|string',
        //     'photo_pass' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        //     'profile' => 'nullable|string',
        //     'languages' => 'nullable|string',
        //     'mbti' => 'nullable|string',
        //     'iq' => 'nullable|string',
        //     'achievements.*' => 'nullable|string',
        //     'skills.*' => 'nullable|string',
        //     'salary_expectation' => 'nullable|min:0',
        //     'salary_current' => 'nullable|min:0',


        //     'role.*' => 'nullable|string|max:255',
        //     'desc_kerja.*' => 'nullable|string',
        //     'name_company.*' => 'nullable|string',
        //     'mulai.*' => 'nullable|date',
        //     // 'selesai.*' => 'date',

        //     'project_name.*' => 'nullable|string|max:255',
        //     'client.*' => 'nullable|string|max:255',
        //     'desc_project.*' => 'nullable|string',
        //     'mulai_project.*' => 'nullable|date',
        //     'selesai_project.*' => 'nullable|date',

        //     'name_ref.*' => 'nullable|string|max:255',
        //     'phone.*' => 'nullable|string|max:255',
        //     'email_ref.*' => 'nullable|string',

        //     'education' => 'nullable|exists:education,id',
        //     'jurusan' => 'nullable|string|max:255',
        // ]);

        // Retrieve the applicant
        $applicant = Auth::user()->applicant;


        if ($applicant->jurusan) {
            $applicant->jurusan->update([
                'name_jurusan' => $request->jurusan
            ]);
        } else {
            // Jika tidak ada, buat data jurusan baru
            $newJurusan = Jurusan::create([
                'name_jurusan' => $request->jurusan,
                'education_id' => $request->education
            ]);
            $applicant->jurusan_id = $newJurusan->id;
            $applicant->save();
        }

        // Handle file upload for photo_pass if provided
        if ($request->hasFile('photo_pass')) {
            // Storage::disk('public')->delete($applicant->photo_pass);
            if (!empty($applicant->cv) && Storage::disk('public')->exists($applicant->cv)) {
                Storage::disk('public')->delete($applicant->cv);
            }
            $path = $request->file('photo_pass')->store('photos', 'public');
            $applicant->update(['photo_pass' => $path]);
        }

        //=== bagian ubah input text jadi integer, karena di input type nya text untuk keperluan formating =======
        $salary_expectation = $request->input('salary_expectation');
        $salary_expectation = str_replace(['.', ','], '', $salary_expectation);
        $salary_expectation = (int) $salary_expectation;


        //=== bagian ubah input text jadi integer, karena di input type nya text untuk keperluan formating =======
        $salary_current = $request->input('salary_current');
        $salary_current = str_replace(['.', ','], '', $salary_current);
        $salary_current = (int) $salary_current;
        //=====================================
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
            'salary_expectation' => $salary_expectation,
            'salary_current' => $salary_current,

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
                    'selesai' => $request->present[$index] == 'present' ? Carbon::today() : $request->selesai[$index],
                    'present' => $request->present[$index],
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

        return redirect()->route('applicant_page.profile')->with('success', 'Applicant updated successfully.');
    }

    public function downloadcv(){
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('applicant_page.profile')->with('error', 'Applicant not found.');
        }

        $pdf = PDF::loadView('pipelines.pdf', ['applicant' => $applicant])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('applicant-cv-' . $applicant->name . '.pdf');
    }


    public function apply($id){
        $applicant = Auth::user()->applicant;
        $applicant->getJob()->syncWithoutDetaching([
            $id => [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        return redirect()->back()->with('success', 'You have been aplied this job');
    }

    public function application(){
        $applicant = Auth::user()->applicant;
        $applications = $applicant->getJob;
        return view('applicants_page.applications', compact('applications'));
    }
}
