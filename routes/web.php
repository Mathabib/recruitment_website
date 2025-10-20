<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ResindoController;
use App\Http\Controllers\OfferLetterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\userManagementController;
use App\Http\Controllers\ApplicantPageController;
use App\Http\Controllers\Auth\ApplicantRegisterController;



use App\Models\Applicant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth/login');
// });


Route::get('/list', [VacancyController::class, 'list'])->name('vacancy_list');
Route::get('/list1', [VacancyController::class, 'list2'])->name('list');
Route::get('/job/{job}', [VacancyController::class, 'showJobDetails'])->name('vacancy.details');
Route::get('/vacancy/{id}', [VacancyController::class, 'index'])->name('vacancy');
Route::get('/list1/search', [VacancyController::class, 'search'])->name('vacancy.search');
Route::get('/form/{id}', [VacancyController::class, 'form'])->name('vacancy_form');
Route::get('/form-resindo', [ResindoController::class, 'formresindo'])->name('form-resindo');

Route::post('/kirim', [VacancyController::class, 'kirim'])->name('kirim');
Route::post('/kirimresindo', [ResindoController::class, 'kirimresindo'])->name('kirimresindo');



Auth::routes();
Route::middleware(['admin.only', 'auth'])->group(function(){

    Route::get('/profile',[UserController::class, 'index'])->name('profile.index');
    Route::post('/profile_update',[UserController::class, 'update'])->name('profile.update');

    Route::resource('jobs', \App\Http\Controllers\JobController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('pipelines', ApplicantController::class);
    Route::resource('education', EducationController::class);
    Route::resource('jurusan', JurusanController::class);

    // =====RESINDO=====
    Route::resource('pipelines-resindo', ResindoController  ::class);
    Route::get('/pipelines-resindo/{id}/pdf', [ResindoController::class, 'generateCV'])->name('applicants.generateCV');
    Route::get('/pipelines/{id}/pdf2', [ResindoController::class, 'generateCV'])->name('applicants.generateCV');
    Route::get('/pipelines/{id}/summary', [ResindoController::class, 'generateSummary'])->name('applicants.generateSummary');

    Route::get('/pipelines-resindo/{id}/summary', [ResindoController::class, 'generateSummary'])->name('applicants.generateSummary');
    Route::get('pipelines-resindo', [ResindoController::class, 'indexresindo'])
        ->name('pipelines-resindo.index');

    Route::get('/export-applicant', [ExportController::class, 'export'])->name('export.applicant');
    Route::post('/import-excel', [ImportController::class, 'import'])->name('import.excel');

    Route::get('pipelines', [ApplicantController::class, 'index'])->name('pipelines.index');
    Route::put('pipelines/{id}/updateStatus', [ApplicantController::class, 'updateStatus'])->name('applicants.updateStatus');
    Route::get('/pipelines/{id}/pdf', [ApplicantController::class, 'generatePdf'])->name('applicants.generatePdf');
    Route::post('/applicant/recommend', [ApplicantController::class, 'updateRecommendation'])->name('applicant.recommend');
    Route::delete('/pipelines/{applicant}', [ApplicantController::class, 'destroy'])->name('pipelines.destroy');
    Route::get('/get-jurusan/{education_id}', [ApplicantController::class, 'getJurusan']);

    // ====NOTES====
    Route::get('/getnotes/{id}', [ApplicantController::class, 'getNotes'])->name('getnotes');
    Route::post('/save-notes', [ApplicantController::class, 'saveNotes'])->name('save.notes');
    Route::post('/delete-notes', [ApplicantController::class, 'deleteNotes'])->name('delete.notes');

    //route for major
    Route::get('showEducationMajor/{id}', [JurusanController::class, 'showEducationMajor'])->name('showEducationMajor');
    Route::get('educationMajorCreate/{id}', [JurusanController::class, 'educationMajorCreate'])->name('educationMajorCreate');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //ganti TYPE DATA pelamar isolutions, resindo dll
    Route::post('pipelines/changetype', [ApplicantController::class, 'changeType'])->name('pipelines.changetype');

    Route::patch('/jobs/{id}/update-status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');

    Route::patch('/jobs/{job}/update-status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');




});


//route for offer letter
Route::prefix('offer-letters')->middleware(['admin.only', 'auth'])->group(function () {
    Route::get('create/{applicantId}', [OfferLetterController::class, 'create'])->name('offer_letters.create');
    Route::post('store', [OfferLetterController::class, 'store'])->name('offer_letters.store');
    Route::get('{id}', [OfferLetterController::class, 'show'])->name('offer_letters.show');
    Route::get('{id}/download', [OfferLetterController::class, 'downloadPdf'])->name('offer_letters.download');

    //edit update route
    Route::get('{id}/edit', [OfferLetterController::class, 'edit'])->name('offer_letters.edit');
    Route::put('{id}', [OfferLetterController::class, 'update'])->name('offer_letters.update');

    //route send mail
    Route::post('/offer_letters/{id}/send_email', [OfferLetterController::class, 'sendEmail'])
    ->name('offer_letters.send_email');
});

Route::middleware('auth')->group(function(){
    // ======MANAGEMENT USER=======

    Route::get('/management/user', [userManagementController::class, 'index'])->name('management.user.index');
    Route::get('/management/user/edit/{id}', [userManagementController::class, 'edit'])->name('management.user.edit');
    Route::post('/management/user/update', [userManagementController::class, 'update'])->name('management.user.update');
    Route::get('/management/user/create', [userManagementController::class, 'create'])->name('management.user.create');
    Route::post('/management/user/store', [userManagementController::class, 'store'])->name('management.user.store');
    Route::get('/management/user/delete/{id}', [userManagementController::class, 'delete'])->name('management.user.delete');

    //==========PERMISSION MANAGEMENT=======
    Route::get('/management/role', [userManagementController::class, 'role_index'])->name('management.role.index');
    Route::get('/management/role/create', [userManagementController::class, 'role_create'])->name('management.role.create');
    Route::post('/management/role/store', [userManagementController::class, 'role_store'])->name('management.role.store');
    Route::get('/management/role/edit/{id}', [userManagementController::class, 'role_edit'])->name('management.role.edit');
    Route::post('/management/role/update/', [userManagementController::class, 'role_update'])->name('management.role.update');
    Route::get('/management/role/delete/{id}', [userManagementController::class, 'role_delete'])->name('management.role.delete');

    // Route::get('/management/permission', [userManagementController::class, 'permission_index'])->name('management.permission.index')->middleware('auth');
    // Route::get('/management/permission/create', [userManagementController::class, 'permission_create'])->name('management.permission.create')->middleware('auth');
    // Route::get('/management/permission/store', [userManagementController::class, 'permission_store'])->name('management.permission.store')->middleware('auth');
    // Route::get('/management/permission/delete/{id}', [userManagementController::class, 'permission_delete'])->name('management.permission.delete')->middleware('auth');

});

//================APPLICANT PAGE===================

Route::middleware(['applicant.only', 'auth'])->group(function(){
    //edit data dan CV
    Route::get('loker/cv/edit/', [ApplicantPageController::class, 'edit'])->name('applicant_page.edit');
    Route::put('loker/cv/update', [ApplicantPageController::class, 'update'])->name('applicant_page.update');
    Route::get('loker/cv/download', [ApplicantPageController::class, 'downloadcv'])->name('applicant_page.download');
    Route::get('loker/profile', [ApplicantPageController::class, 'profile'])->name('applicant_page.profile');
    Route::get('loker/profile/cvsection', [ApplicantPageController::class, 'cvsection'])->name('applicant_page.cvsection');

    //edit satu satu
    Route::post('loker/profile/cvsection/profiledata', [ApplicantPageController::class, 'editProfileData1'])->name('applicant_page.cvsection.profiledata1');
    Route::post('loker/profile/cvsection/profiledata2', [ApplicantPageController::class, 'editProfileData2'])->name('applicant_page.cvsection.profiledata2');
    Route::post('loker/profile/cvsection/profiledata3', [ApplicantPageController::class, 'editProfileData3'])->name('applicant_page.cvsection.profiledata3');
    Route::post('loker/profile/cvsection/profiledata4', [ApplicantPageController::class, 'editProfileData4'])->name('applicant_page.cvsection.profiledata4');
    Route::post('loker/profile/cvsection/profiledata5', [ApplicantPageController::class, 'editProfileData5'])->name('applicant_page.cvsection.profiledata5');

    Route::post('loker/profile/cvsection/experience/edit', [ApplicantPageController::class, 'experienceEdit'])->name('applicant_page.cvsection.experienceEdit');
    Route::post('loker/profile/cvsection/experience/add', [ApplicantPageController::class, 'experienceAdd'])->name('applicant_page.cvsection.experienceAdd');
    Route::get('loker/profile/cvsection/experience/delete/{id}', [ApplicantPageController::class, 'experienceDelete'])->name('applicant_page.cvsection.experienceDelete');

    //CHANGE PASSWORD
    Route::post('loker/profile/changepassword', [ApplicantPageController::class, 'changePassword'])->name('applicant_page.changePassword');




    //lamar pekerjaan
    Route::get('loker/jobs/apply/{id}', [ApplicantPageController::class, 'apply'])->name('applicant_page.jobs.apply');
    Route::get('loker/jobs/unapply/{id}', [ApplicantPageController::class, 'delete_application'])->name('applicant_page.jobs.unapply');
    Route::get('loker/jobs/applications', [ApplicantPageController::class, 'application'])->name('applicant_page.jobs.applications');
});



Route::middleware('applicant.only')->group(function(){

    Route::get('/', [ApplicantPageController::class, 'jobs'])->name('applicant_page.jobs');
    Route::get('loker/home', [ApplicantPageController::class, 'index'])->name('applicant_page.index');
    Route::post('loker/register/', [ApplicantRegisterController::class, 'register'])->name('applicant_page.register');

    //lamar pekerjaan
    Route::get('loker/jobs', [ApplicantPageController::class, 'jobs'])->name('applicant_page.jobs');
});

Route::get('/loker/jobs/show/{job}', [ApplicantPageController::class, 'jobsShow'])->name('applicant_page.jobs.show');
Route::get('/loker/jobs/email', [ApplicantPageController::class, 'testEmail'])->name('applicant_page.testemail');





