<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\BoardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubItemController;
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
    return view('homepage');
})->name('homepage');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('settings/notifications', 'profile.settingNotifications')->name('settingNotifications');

    Route::get('/workspaces', [WorkspaceController::class, 'index'])->name('workspaces');
    Route::post('/workspaces/store', [WorkspaceController::class, 'store'])->name('workspaces.store');
    Route::get('/workspaces/{id}/show', [WorkspaceController::class, 'show'])->name('workspaces.show');
    Route::delete('/workspaces/{id}/delete', [WorkspaceController::class, 'destroy'])->name('workspaces.delete');
    Route::put('/workspaces/{id}/update-cover', [WorkspaceController::class, 'updateCover'])->name('workspaces.updateCover');
    Route::put('/workspaces/{id}/update', [WorkspaceController::class, 'update'])->name('workspaces.update');
    Route::post('/workspaces/{id}/star', [WorkspaceController::class, 'starToggle'])->name('workspaces.starToggle');
    Route::delete('/workspaces/{id}/revoke/{userId}/user', [WorkspaceController::class, 'revokeAccess'])->name('workspaces.revokeAccess');

    // Invitation
    Route::post('/invitation/store', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('/invitation/{id}/resend', [InvitationController::class, 'resend'])->name('invitations.resend');
    Route::delete('/invitation/{id}/delete', [InvitationController::class, 'destroy'])->name('invitations.delete');
    // End Invitation

    // Project Routes
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{id}/details', [ProjectController::class, 'show'])->name('project.show');
    Route::delete('/project/{id}/delete', [ProjectController::class, 'destroy'])->name('project.delete');
    Route::put('/project/{id}/update', [ProjectController::class, 'update'])->name('project.update');
    Route::post('/project/{id}/star', [ProjectController::class, 'starToggle'])->name('project.starToggle');
    Route::delete('/project/{id}/revoke/{userId}/user', [ProjectController::class, 'revokeAccess'])->name('project.revokeAccess');

    // Board Routes
    Route::post('/board/store', [BoardController::class, 'store'])->name('board.store');
    Route::put('/board/{id}/update', [BoardController::class, 'update'])->name('board.update');
    Route::get('/project/{id}/boards-history', [BoardController::class, 'history'])->name('board.history');
    Route::delete('/board/{id}/delete', [BoardController::class, 'destroy'])->name('board.delete');
    // End Board Routes

    // Task Routes
    Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
    Route::get('/task/show', [TaskController::class, 'show'])->name('task.show');
    Route::put('/task/{id}/update', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/{id}/delete', [TaskController::class, 'destroy'])->name('task.delete');
    Route::post('/task/comment/store', [TaskController::class, 'storeComment'])->name('task.storeComment');
    Route::delete('/task/comment/{id}/delete', [TaskController::class, 'destroyComment'])->name('task.deleteComment');
    Route::delete('/replies/{id}', [TaskController::class, 'destroyReply'])->name('reply.destroy');
    Route::get('/task-details/{id}', [TaskController::class, 'details'])->name('task.details');
    Route::post('/tasks/store-reply', [TaskController::class, 'storeReply'])->name('task.storeReply');
    Route::get('/user-suggestions', [TaskController::class, 'getSuggestions'])->name('user.suggestions');


    // End Task Routes

    // End Project Routes


    Route::get('/permission', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/index', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/edit{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::get('/role', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/index', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/edit{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::resource('user', UserController::class);

    // Route::get('/subitem/store', [SubItemController::class, 'store'])->name('subitem.store');
    Route::post('/subitem/store', [SubItemController::class, 'store'])->name('subitem.store');


});

Route::post('/save-editor-data', function (Request $request) {
    $content = $request->input('content');

    // Save the content to the database or perform other actions
    Log::info('Editor Content:', ['content' => $content]);

    return response()->json(['message' => 'Data saved successfully!']);
});


Route::get('/collaborate', [InvitationController::class, 'joinTeam']);

require __DIR__ . '/auth.php';
