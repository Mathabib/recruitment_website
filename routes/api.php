<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ResindoController;
use App\Http\Controllers\ApplicantPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('edit_api/{id}', [ApplicantController::class, 'edit_api'])->name('edit_api');
Route::get('edit_api_resindo/{id}', [ResindoController::class, 'edit_api'])->name('edit_api_resindo');
Route::get('edit_api_applicant/{id}', [ApplicantPageController::class, 'edit_api'])->name('edit_api_applicant');

