<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });

    Route::post('/logout', [AuthenticatedTokenController::class, 'logout']);

    Route::get('/workspace', [WorkspaceController::class, 'index']);

    Route::get('/profile/{id}', [ProfileController::class, 'show']);
    Route::post('/profile/update', [ProfileController::class, 'updateApi']);

    Route::get('/workspace/group/{id}', [GroupController::class, 'index']);
    Route::post('/group/join', [GroupController::class, 'join']);
    Route::post('/group/create', [GroupController::class, 'store']);

    Route::get('/task', [TaskController::class, 'index']);
    Route::post('/task', [TaskController::class, 'storeApi']);
    Route::post('/task/update', [TaskController::class, 'updateApi']);
    Route::delete('/task/{id}', [TaskController::class, 'destroy']);
    Route::delete('/task/attachment/{id}', [TaskController::class, 'destroyAttachment']);
    Route::post('/task/operate', [TaskController::class, 'operate']);

    Route::get('/task/comment', [TaskCommentController::class, 'index']);
    Route::post('/task/comment', [TaskCommentController::class, 'store']);
    Route::delete('/comment/delete/{id}', [TaskCommentController::class, 'destroy']);

    Route::get('/group/list', [GroupController::class, 'show']);
    Route::get('group/information/{id}', [GroupController::class, 'information']);
    Route::get('/group/members/{id}', [GroupController::class, 'getMembers']);
    Route::delete('/group/leave/{id}', [GroupController::class, 'leave']);

    Route::get('/calendar', [CalendarController::class, 'index']);
});


Route::post('register', [AuthenticatedTokenController::class, 'register']);

Route::post('login', [AuthenticatedTokenController::class, 'login']);


