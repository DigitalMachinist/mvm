<?php

use App\Http\Controllers\KeyRooms\CreateKeyRoomController;
use App\Http\Controllers\KeyRooms\DeleteKeyRoomController;
use App\Http\Controllers\KeyRooms\GetKeyRoomController;
use App\Http\Controllers\KeyRooms\UpdateKeyRoomController;
use App\Http\Controllers\Keys\CreateKeyController;
use App\Http\Controllers\Keys\DeleteKeyController;
use App\Http\Controllers\Keys\GetKeyController;
use App\Http\Controllers\Keys\IndexProjectKeysController;
use App\Http\Controllers\Keys\UpdateKeyController;
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

// KeyRooms
Route::get('keys/{id}/rooms/{id2}', GetKeyRoomController::class);

// Keys
Route::get('projects/{id}/keys', IndexProjectKeysController::class);
Route::get('keys/{id}', GetKeyController::class);

// Pathways
Route::get('projects/{id}/pathways', IndexProjectPathwaysController::class);
Route::get('pathways/{id}', GetPathwayController::class);

// Projects
Route::get('projects', IndexProjectsController::class);
Route::get('projects/{id}', GetProjectController::class);
Route::get('users/{id}/projects', IndexUserProjectsController::class);

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

    // KeyRooms CRUD
    Route::post('keys/{id}/rooms', CreateKeyRoomController::class);
    Route::patch('keys/{id}/rooms/{id2}', UpdateKeyRoomController::class);
    Route::delete('keys/{id}/rooms/{id2}', DeleteKeyRoomController::class);

    // Keys CRUD
    Route::post('projects/{id}/keys', CreateKeyController::class);
    Route::patch('keys/{id}', UpdateKeyController::class);
    Route::delete('keys/{id}', DeleteKeyController::class);

    // Pathways CRUD
    Route::post('projects/{id}/pathways', CreatePathwayController::class);
    Route::patch('pathways/{id}', UpdatePathwayController::class);
    Route::delete('pathways/{id}', DeletePathwayController::class);

    // Projects CRUD
    Route::post('projects', CreateProjectController::class);
    Route::patch('projects/{id}', UpdateProjectController::class);
    Route::delete('projects/{id}', DeleteProjectController::class);

    // Rooms CRUD
    Route::post('projects/{id}/rooms', CreateRoomController::class);
    Route::patch('rooms/{id}', UpdateRoomController::class);
    Route::delete('rooms/{id}', DeleteRoomController::class);
});
