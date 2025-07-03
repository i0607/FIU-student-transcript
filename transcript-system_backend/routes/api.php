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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TranscriptController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CurriculumController;


Route::get('/transcripts/{studentNumber}', [TranscriptController::class, 'getTranscript']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();   
 });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/staff', [StaffController::class, 'index']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::put('/staff/{id}', [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);
});
Route::get('/transcripts/{studentNumber}/export/pdf', [TranscriptController::class, 'exportPdf']);
Route::get('/transcripts/{studentNumber}/export/excel', [TranscriptController::class, 'exportExcel']);
Route::middleware('auth:sanctum')->get('/admin/dashboard-stats', [AdminController::class, 'dashboardStats']);
Route::middleware('auth:sanctum')->get('/admin/recent-data', [AdminController::class, 'recentData']);
Route::get('/departments', [DepartmentController::class, 'index']);
Route::post('/departments', [DepartmentController::class, 'store']);
Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/me/password', [AuthController::class, 'changePassword']);
});
Route::middleware('auth:sanctum')->get('/user/profile', function (Request $request) {
    return $request->user();
});

Route::prefix('curriculum')->group(function () {
    
    // Get curriculum by department ID and version
    Route::post('/search', [CurriculumController::class, 'getCurriculumByDepartmentAndVersion'])->name('curriculum.search');
    // Get curriculum by department ID and version 
    Route::get('/search', [CurriculumController::class, 'getCurriculumByDepartmentAndVersion'])->name('curriculum.search.get');  
    // Get all curriculum versions for a specific department
    Route::get('/department/{departmentId}', [CurriculumController::class, 'getCurriculumByDepartment'])
         ->name('curriculum.by.department')
         ->where('departmentId', '[0-9]+'); 
    // Get available departments with their versions
    Route::get('/departments', [CurriculumController::class, 'getAvailableDepartments'])
         ->name('curriculum.departments');
});

// Alternative RESTful routes (if you prefer this style)
Route::apiResource('curriculums', CurriculumController::class)->only(['index', 'show']);
