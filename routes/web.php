<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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
    return view('homepage');
})->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
    // End Project Routes

});

Route::get('/collaborate', [InvitationController::class, 'joinTeam']);

require __DIR__ . '/auth.php';