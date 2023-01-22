<?php

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
    return view('landing');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::prefix('projects/{project_id}')->group(function () {
        Route::resource('plans', App\Http\Controllers\PlanController::class);
        Route::resource('inspects', App\Http\Controllers\InspectController::class);
        Route::prefix('inspects/{inspect_id}')->group(function () {
            Route::resource('issues', App\Http\Controllers\IssueController::class);
        });
    });

    Route::delete('issueFiles/{issue_file_id}', [App\Http\Controllers\IssueFileController::class, 'delete'])->name('issue_files.delete');
});

