<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\EventManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InviteController;


Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('users', SuperAdminController::class);
    Route::get('/admin/usermanagement', [SuperAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [SuperAdminController::class, 'listUsers'])->name('admin.listusers');
    Route::put('/admin/users/{user}', [SuperAdminController::class, 'update'])->name('admin.update');
    Route::post('admin/users/create', [SuperAdminController::class, 'store'])->name('admin.store');


});

Route::middleware(['auth', 'role:event_manager', 'prevent-back-history'])->group(function () {
    Route::get('/eventmanager/dashboard', [EventManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/eventmanager/manage/events', [EventManagerController::class, 'showEvent'])->name('manager.showEvent');
    Route::get('/events/{event}/dashboard', [EventController::class, 'showDashboard'])->name('events.dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/events/booked', [UserController::class, 'bookedEvent'])->name('user.bookedEvents');
});Route::get('/user/events/attending', [UserController::class, 'attendingEvents'])->name('user.attendingEvents');


Route::middleware(['auth'])->group(function () {
    Route::get('/book-now', [EventController::class, 'create'])->name('book-now');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
});

//Event Invitation
Route::get('/invite/{eventId}', [InviteController::class, 'show'])->name('invite.confirm');
Route::get('/invite/accept/{eventId}', [InviteController::class, 'accept'])->name('invite.accept');
Route::get('/invite/decline', [InviteController::class, 'decline'])->name('invite.decline');


require __DIR__.'/auth.php';
