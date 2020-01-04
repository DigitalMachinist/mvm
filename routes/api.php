<?php

use App\Http\Controllers\Projects\CreateProjectController;
use App\Http\Controllers\Projects\DeleteProjectController;
use App\Http\Controllers\Projects\GetProjectController;
use App\Http\Controllers\Projects\IndexProjectsController;
use App\Http\Controllers\Projects\IndexUserProjectsController;
use App\Http\Controllers\Projects\UpdateProjectController;
use Illuminate\Http\Request;

// Projects
Route::get('projects', IndexProjectsController::class);
Route::get('projects/{id}', GetProjectController::class);

// User Projects
Route::get('users/{id}/projects', IndexUserProjectsController::class);

// Require Authentication
Route::group([
    'middleware' => [
        \App\Http\Middleware\Authenticate::class,
    ],
], function () {
    // Self User
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // Projects CRUD
    Route::post('projects', CreateProjectController::class);
    Route::patch('projects/{id}', UpdateProjectController::class);
    Route::delete('projects/{id}', DeleteProjectController::class);
});
