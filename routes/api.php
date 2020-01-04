<?php

use App\Http\Controllers\Pathways\CreatePathwayController;
use App\Http\Controllers\Pathways\DeletePathwayController;
use App\Http\Controllers\Pathways\GetPathwayController;
use App\Http\Controllers\Pathways\IndexProjectPathwaysController;
use App\Http\Controllers\Pathways\UpdatePathwayController;
use App\Http\Controllers\Projects\CreateProjectController;
use App\Http\Controllers\Projects\DeleteProjectController;
use App\Http\Controllers\Projects\GetProjectController;
use App\Http\Controllers\Projects\IndexProjectsController;
use App\Http\Controllers\Projects\IndexUserProjectsController;
use App\Http\Controllers\Projects\UpdateProjectController;
use App\Http\Controllers\Rooms\CreateRoomController;
use App\Http\Controllers\Rooms\DeleteRoomController;
use App\Http\Controllers\Rooms\GetRoomController;
use App\Http\Controllers\Rooms\IndexProjectRoomsController;
use App\Http\Controllers\Rooms\UpdateRoomController;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;

// Users
// TODO

// Projects
Route::get('projects', IndexProjectsController::class);
Route::get('projects/{id}', GetProjectController::class);
Route::get('users/{id}/projects', IndexUserProjectsController::class);

// Keys
// TODO

// Pathways
Route::get('projects/{id}/pathways', IndexProjectPathwaysController::class);
Route::get('pathways/{id}', GetPathwayController::class);

// Rooms
Route::get('projects/{id}/rooms', IndexProjectRoomsController::class);
Route::get('rooms/{id}', GetRoomController::class);

// Require Authentication
Route::group([
    'middleware' => [
        Authenticate::class,
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

    // Pathways CRUD
    Route::post('projects/{id}/pathways', CreatePathwayController::class);
    Route::patch('pathways/{id}', UpdatePathwayController::class);
    Route::delete('pathways/{id}', DeletePathwayController::class);

    // Rooms CRUD
    Route::post('projects/{id}/rooms', CreateRoomController::class);
    Route::patch('rooms/{id}', UpdateRoomController::class);
    Route::delete('rooms/{id}', DeleteRoomController::class);
});
