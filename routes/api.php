<?php

// Auth Routes (Heavily Throttled)
Route::group([
    'middleware' => [
        'throttle:5,5',
    ],
], function () {
    Route::post('login',                        App\Http\Controllers\Auth\LoginController::class);
    Route::post('password',                     App\Http\Controllers\Auth\SetPasswordController::class);
    Route::post('password/forgot',              App\Http\Controllers\Auth\ForgotPasswordController::class);
    Route::post('refresh',                      App\Http\Controllers\Auth\RefreshController::class);
    Route::post('register',                     App\Http\Controllers\Auth\RegisterController::class);
    Route::post('verify',                       App\Http\Controllers\Auth\VerifyEmailController::class);
    Route::post('verify/resend',                App\Http\Controllers\Auth\ResendVerifyEmailController::class);
});

// Public Routes
Route::group([
    'middleware' => [
        'throttle:60,1',
    ],
], function () {
    // Keys
    Route::get('projects/{id}/keys',            App\Http\Controllers\Keys\IndexProjectKeysController::class);
    Route::get('keys/{id}',                     App\Http\Controllers\Keys\GetKeyController::class);
    Route::get('keys/{id}/pathways/{id2}',      App\Http\Controllers\KeyPathways\GetKeyPathwayController::class);
    Route::get('keys/{id}/rooms/{id2}',         App\Http\Controllers\KeyRooms\GetKeyRoomController::class);

    // Pathways
    Route::get('projects/{id}/pathways',        App\Http\Controllers\Pathways\IndexProjectPathwaysController::class);
    Route::get('pathways/{id}',                 App\Http\Controllers\Pathways\GetPathwayController::class);

    // Projects
    Route::get('projects',                      App\Http\Controllers\Projects\IndexProjectsController::class);
    Route::get('projects/{id}',                 App\Http\Controllers\Projects\GetProjectController::class);
    Route::get('users/{id}/projects',           App\Http\Controllers\Projects\IndexUserProjectsController::class);

    // Rooms
    Route::get('projects/{id}/rooms',           App\Http\Controllers\Rooms\IndexProjectRoomsController::class);
    Route::get('rooms/{id}',                    App\Http\Controllers\Rooms\GetRoomController::class);
});

// Require Authentication
Route::group([
    'middleware' => [
        'throttle:60,1',
        'auth:api',
    ],
], function () {
    // Auth
    Route::post('logout',                       App\Http\Controllers\Auth\LogoutController::class);
    Route::get('user',                          App\Http\Controllers\Users\GetSelfUserController::class);

    // Keys CRUD
    Route::post('projects/{id}/keys',           App\Http\Controllers\Keys\CreateKeyController::class);
    Route::patch('keys/{id}',                   App\Http\Controllers\Keys\UpdateKeyController::class);
    Route::delete('keys/{id}',                  App\Http\Controllers\Keys\DeleteKeyController::class);
    Route::post('keys/{id}/pathways',           App\Http\Controllers\KeyPathways\CreateKeyPathwayController::class);
    Route::patch('keys/{id}/pathways/{id2}',    App\Http\Controllers\KeyPathways\UpdateKeyPathwayController::class);
    Route::delete('keys/{id}/pathways/{id2}',   App\Http\Controllers\KeyPathways\DeleteKeyPathwayController::class);
    Route::post('keys/{id}/rooms',              App\Http\Controllers\KeyRooms\CreateKeyRoomController::class);
    Route::patch('keys/{id}/rooms/{id2}',       App\Http\Controllers\KeyRooms\UpdateKeyRoomController::class);
    Route::delete('keys/{id}/rooms/{id2}',      App\Http\Controllers\KeyRooms\DeleteKeyRoomController::class);

    // Pathways CRUD
    Route::post('projects/{id}/pathways',       App\Http\Controllers\Pathways\CreatePathwayController::class);
    Route::patch('pathways/{id}',               App\Http\Controllers\Pathways\UpdatePathwayController::class);
    Route::delete('pathways/{id}',              App\Http\Controllers\Pathways\DeletePathwayController::class);

    // Projects CRUD
    Route::post('projects',                     App\Http\Controllers\Projects\CreateProjectController::class);
    Route::patch('projects/{id}',               App\Http\Controllers\Projects\UpdateProjectController::class);
    Route::delete('projects/{id}',              App\Http\Controllers\Projects\DeleteProjectController::class);

    // Rooms CRUD
    Route::post('projects/{id}/rooms',          App\Http\Controllers\Rooms\CreateRoomController::class);
    Route::patch('rooms/{id}',                  App\Http\Controllers\Rooms\UpdateRoomController::class);
    Route::delete('rooms/{id}',                 App\Http\Controllers\Rooms\DeleteRoomController::class);
});
