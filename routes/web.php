<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupManagerController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('workspace');
    }
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace');
    Route::get('/console', function () {
        return view('console');
    })->name('console');

});
Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/workspace/group/{id}', [GroupController::class, 'index']);
    Route::post('/group/join', [GroupController::class, 'join'])->name('group.join');
    Route::post('/group/create', [GroupController::class, 'store'])->name('group.store');

    Route::post('/task', [TaskController::class, 'store'])->name('task.store');
    Route::post('/task/update', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::get('/task/member', [TaskController::class, 'search']);
    Route::delete('/task/member/{id}', [TaskController::class, 'destroyMember']);
    Route::delete('/task/attachment/{id}', [TaskController::class, 'destroyAttachment']);
    Route::post('/task/operate', [TaskController::class, 'operate'])->name('task.operate');

    Route::get('/task/comment', [TaskCommentController::class, 'index'])->name('comment.index');
    Route::post('/task/comment', [TaskCommentController::class, 'store'])->name('comment.store');
    Route::delete('/task/comment/{id}', [TaskCommentController::class, 'destroy'])->name('comment.destroy');

    Route::get('/chat/{id}', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat', [MessageController::class, 'store'])->name('chat.store');
    Route::post('/chat/connect', [MessageController::class, 'connect'])->name('chat.connect');
    Route::get('/video-call/{id}', [MessageController::class, 'video']);
    Route::get('/video-call', [MessageController::class, 'video']);

    Route::get('/mail', [MailController::class, 'index']);
    Route::post('/mail', [MailController::class, 'store'])->name('mail.store');
    Route::delete('/mail/{id}', [MailController::class, 'destroy']);

    Route::post('/gmail', [GmailController::class, 'store']);

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('/group-manager', [GroupManagerController::class, 'index'])->name('group-manager.index');
    Route::get('/group-manager/{id}', [GroupManagerController::class, 'show'])->name('group-manager.show');
    Route::post('/group-manager', [GroupManagerController::class, 'update'])->name('group-manager.update');
    Route::get('/group-manager/kick/{gID}/{mID}', [GroupManagerController::class, 'kick']);
    Route::get('/group-manager/destroy/{id}', [GroupManagerController::class, 'destroy']);

    Route::post('/activity/connect/{id}', [UserActivityController::class, 'connect']);
    Route::post('/activity/disconnect/', [UserActivityController::class, 'disconnect'])->name('activity.disconnect');

});

require __DIR__ . '/auth.php';
