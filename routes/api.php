<?php

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

Route::prefix('v1')->group(function()
{
  Route::get('/AuthenticateMe/{u}/{p}', [App\Http\Controllers\SignInController::class, 'AuthenticateMe'])->name('AuthenticateMe');
  Route::get('/CandidateProfile/{mat}', [App\Http\Controllers\SignInController::class, 'CandidateProfile'])->name('CandidateProfile');
  #Upload Document
  Route::get('/DocumentUpload/{guid}', [App\Http\Controllers\AppApiController::class, 'DocumentUpload'])->name('DocumentUpload');
  #Upload Document
  Route::get('/GetBiodataPayment', [App\Http\Controllers\AppApiController::class, 'GetBiodataPayment'])->name('GetBiodataPayment');
  #GetBiodataInfo
  Route::get('/GetBiodataInfo', [App\Http\Controllers\AppApiController::class, 'GetBiodataInfo'])->name('GetBiodataInfo');
  Route::get('/GetBiodataInfoByMatricNo/{mat}', [App\Http\Controllers\AppApiController::class, 'GetBiodataInfoByMatricNo'])->name('GetBiodataInfoByMatricNo');
  #GetStudentPaymentInfo
  Route::get('/GetStudentPaymentInfo', [App\Http\Controllers\AppApiController::class, 'GetStudentPaymentInfo'])->name('GetStudentPaymentInfo');
  Route::get('/GetStudentPaymentInfoByMatricno/{mat}', [App\Http\Controllers\AppApiController::class, 'GetStudentPaymentInfoByMatricno'])->name('GetStudentPaymentInfoByMatricno');
  #UpdateStudentBiodataInfo
  Route::post('/UpdateStudentBiodataInfo', [App\Http\Controllers\AppApiController::class, 'UpdateStudentBiodataInfo'])->name('UpdateStudentBiodataInfo');
  Route::get('/UpdateMatriculationNumber/{mat}', [App\Http\Controllers\AppApiController::class, 'UpdateMatriculationNumber'])->name('UpdateMatriculationNumber');
  #UpdateMatriculationNumber
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
