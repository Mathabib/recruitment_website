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

Route::get('/', function () {
    return view('auth/login');
});

// ===== PROFILE =====
Route::get('/profile',[UserController::class, 'index'])->name('profile.index');
Route::post('/profile_update',[UserController::class, 'update'])->name('profile.update');

Auth::routes();
Route::resource('jobs', \App\Http\Controllers\JobController::class)->middleware('auth');
Route::resource('departements', DepartementController::class)->middleware('auth');
Route::resource('pipelines', ApplicantController::class)->middleware('auth');
Route::resource('education', EducationController::class)->middleware('auth');
Route::resource('jurusan', JurusanController::class)->middleware('auth');

// =====RESINDO=====

Route::resource('pipelines-resindo', ResindoController  ::class)->middleware('auth');
Route::get('/pipelines-resindo/{id}/pdf', [ResindoController::class, 'generateCV'])->name('applicants.generateCV')->middleware('auth');
Route::get('/pipelines/{id}/pdf2', [ResindoController::class, 'generateCV'])->name('applicants.generateCV')->middleware('auth');
Route::get('/pipelines/{id}/summary', [ResindoController::class, 'generateSummary'])->name('applicants.generateSummary')->middleware('auth');


Route::get('/pipelines-resindo/{id}/summary', [ResindoController::class, 'generateSummary'])->name('applicants.generateSummary')->middleware('auth');
Route::get('pipelines-resindo', [ResindoController::class, 'indexresindo'])
    ->name('pipelines-resindo.index')  
    ->middleware('auth');


Route::get('/export-applicant', [ExportController::class, 'export'])->name('export.applicant');
Route::post('/import-excel', [ImportController::class, 'import'])->name('import.excel');

Route::get('pipelines', [ApplicantController::class, 'index'])->name('pipelines.index')->middleware('auth');
Route::put('pipelines/{id}/updateStatus', [ApplicantController::class, 'updateStatus'])->name('applicants.updateStatus')->middleware('auth');
Route::get('/pipelines/{id}/pdf', [ApplicantController::class, 'generatePdf'])->name('applicants.generatePdf')->middleware('auth');
Route::post('/applicant/recommend', [ApplicantController::class, 'updateRecommendation'])->name('applicant.recommend');
Route::delete('/pipelines/{applicant}', [ApplicantController::class, 'destroy'])->name('pipelines.destroy');
Route::get('/get-jurusan/{education_id}', [ApplicantController::class, 'getJurusan']);

// Route::resource('pipelines', PipelineController::class);
Route::patch('/jobs/{id}/update-status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::patch('/jobs/{job}/update-status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');
Route::get('/list', [VacancyController::class, 'list'])->name('vacancy_list');
Route::get('/list1', [VacancyController::class, 'list2'])->name('list');
Route::get('/job/{job}', [VacancyController::class, 'showJobDetails'])->name('vacancy.details');
Route::get('/list1/search', [VacancyController::class, 'search'])->name('vacancy.search');
Route::get('/form/{id}', [VacancyController::class, 'form'])->name('vacancy_form');
Route::get('/form-resindo', [ResindoController::class, 'formresindo'])->name('form-resindo');

Route::post('/kirim', [VacancyController::class, 'kirim'])->name('kirim');
Route::post('/kirimresindo', [ResindoController::class, 'kirimresindo'])->name('kirimresindo');

// ====NOTES====
Route::get('/{id}', [App\Http\Controllers\VacancyController::class, 'index'])->name('vacancy');
Route::get('/getnotes/{id}', [ApplicantController::class, 'getNotes'])->name('getnotes');
Route::post('/save-notes', [ApplicantController::class, 'saveNotes'])->name('save.notes');
Route::post('/delete-notes', [ApplicantController::class, 'deleteNotes'])->name('delete.notes');

//route for major
Route::get('showEducationMajor/{id}', [JurusanController::class, 'showEducationMajor'])->name('showEducationMajor');
Route::get('educationMajorCreate/{id}', [JurusanController::class, 'educationMajorCreate'])->name('educationMajorCreate');

//route for offer letter
Route::prefix('offer-letters')->group(function () {
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


// ======MANAGEMENT USER=======

Route::get('/management/user', [userManagementController::class, 'index'])->name('management.user.index')->middleware('auth');
Route::get('/management/user/edit/{id}', [userManagementController::class, 'edit'])->name('management.user.edit')->middleware('auth');
Route::post('/management/user/update', [userManagementController::class, 'update'])->name('management.user.update')->middleware('auth');
Route::get('/management/user/create', [userManagementController::class, 'create'])->name('management.user.create')->middleware('auth');
Route::post('/management/user/store', [userManagementController::class, 'store'])->name('management.user.store')->middleware('auth');
Route::get('/management/user/delete/{id}', [userManagementController::class, 'delete'])->name('management.user.delete')->middleware('auth');

//==========PERMISSION MANAGEMENT=======
Route::get('/management/role', [userManagementController::class, 'role_index'])->name('management.role.index')->middleware('auth');
Route::get('/management/role/create', [userManagementController::class, 'role_create'])->name('management.role.create')->middleware('auth');
Route::post('/management/role/store', [userManagementController::class, 'role_store'])->name('management.role.store')->middleware('auth');
Route::get('/management/role/edit/{id}', [userManagementController::class, 'role_edit'])->name('management.role.edit')->middleware('auth');
Route::post('/management/role/update/', [userManagementController::class, 'role_update'])->name('management.role.update')->middleware('auth');
Route::get('/management/role/delete/{id}', [userManagementController::class, 'role_delete'])->name('management.role.delete')->middleware('auth');

// Route::get('/management/permission', [userManagementController::class, 'permission_index'])->name('management.permission.index')->middleware('auth');
// Route::get('/management/permission/create', [userManagementController::class, 'permission_create'])->name('management.permission.create')->middleware('auth');
// Route::get('/management/permission/store', [userManagementController::class, 'permission_store'])->name('management.permission.store')->middleware('auth');
// Route::get('/management/permission/delete/{id}', [userManagementController::class, 'permission_delete'])->name('management.permission.delete')->middleware('auth');

//testing 
Route::get('/test/{id}', [JurusanController::class, 'showEducationMajor'])->name('test');



