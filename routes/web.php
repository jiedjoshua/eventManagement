<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\EventManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;


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

    Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
    Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');
    Route::get('/venues/{venue}/edit', [VenueController::class, 'edit'])->name('venues.edit');
});

Route::middleware(['auth', 'role:event_manager', 'prevent-back-history'])->group(function () {
    Route::get('/manager/dashboard', [EventManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/manage/events', [EventManagerController::class, 'showEvent'])->name('manager.showEvent');

    Route::get('/manager/upcoming-events', [EventManagerController::class, 'upcomingEvents'])->name('manager.upcomingEvents');
    Route::get('/manager/events/{event}/details', [EventManagerController::class, 'details'])->name('events.details');
    Route::patch('/manager/events/{event}/reschedule', [EventManagerController::class, 'reschedule'])->name('manager.events.reschedule');

    Route::get('/events/{event}/dashboard', [EventController::class, 'showDashboard'])->name('events.dashboard');
    Route::get('/events/{event}/qrscanner', [EventController::class, 'showQRScanner'])->name('events.qrScanner');
    Route::get('/events/{event}/guests', [EventController::class, 'showGuestList'])->name('events.guests');
    Route::get('/events/{event}/checkedin', [EventController::class, 'showCheckedInList'])->name('events.checkedIn');
    Route::get('/checkin/scan', [EventController::class, 'scanCheckIn'])->name('checkin.scan');
    Route::get('/events/{event}/manual-checkin', [EventController::class, 'showManualCheckin'])->name('events.manualCheckin');
    Route::get('/events/{event}/search-guests', [EventController::class, 'searchGuests'])->name('events.searchGuests');
    Route::post('/events/{event}/check-in/{guestId}', [EventController::class, 'manualCheckIn'])->name('events.manualCheckIn');



    // Booking Management
    Route::get('/manager/booked-events', [EventManagerController::class, 'showBooked'])->name('manager.bookedEvents');
    Route::patch('/manager/bookings/{booking}/approve', [EventManagerController::class, 'approve'])->name('manager.approveBooking');
    Route::patch('/manager/bookings/{booking}/reject', [EventManagerController::class, 'reject'])->name('manager.rejectBooking');
    Route::get('/manager/bookings/{booking}/details', [EventManagerController::class, 'getDetails']);

    Route::get('/manager/guest-lists', [EventManagerController::class, 'showGuestLists'])->name('manager.guestLists');
    Route::get('/manager/events/{event}/guests', [EventManagerController::class, 'guests'])->name('manager.event.guests');

    Route::get('/manager/generate-external-qr-codes', [EventManagerController::class, 'showGenerateExternalQRCodes'])->name('manager.showGenerateExternalQRCodes');
    Route::post('/manager/generate-external-qr-codes', [EventController::class, 'generateExternalQRCodes'])->name('manager.generateExternalQRCodes');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/events/booked', [UserController::class, 'bookedEvents'])->name('user.bookedEvents');

    Route::get('user/bookings/{reference}/edit', [UserController::class, 'editBooking'])->name('bookings.edit');
    Route::post('user/bookings/{reference}/update', [UserController::class, 'updateBooking'])->name('bookings.update');
    Route::get('/user/payments', [UserController::class, 'payments'])->name('user.payments');
    Route::get('/user/account-settings', [UserController::class, 'showAccountSettings'])->name('user.accountSettings');
    
});
Route::get('/user/events/attending', [UserController::class, 'attendingEvents'])->name('user.attendingEvents');


Route::middleware(['auth'])->group(function () {
    Route::get('/book-now', [EventController::class, 'create'])->name('book-now');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
});

//Event Invitation
Route::get('/invite/decline/{eventId}', [InviteController::class, 'decline'])->name('invite.decline');
Route::get('/invite/{eventId}', [InviteController::class, 'show'])->name('invite.confirm');
Route::get('/invite/accept/{eventId}', [InviteController::class, 'accept'])->name('invite.accept');

//Venue Routes
Route::prefix('venues')->group(function () {
    Route::get('/', [VenueController::class, 'index']);
    Route::get('/{venue}', [VenueController::class, 'show']);
    Route::post('/', [VenueController::class, 'store']);
});

// Package Routes
Route::get('/api/packages', [PackageController::class, 'getPackages']);
Route::get('/api/packages/{id}', [PackageController::class, 'getPackage']);

// Booking Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/bookings', [EventController::class, 'store'])->name('bookings.store');

    Route::get('/bookings/trace', [EventController::class, 'traceBooking'])->name('bookings.trace');
    Route::get('/bookings/{reference}', [EventController::class, 'showBooking'])->name('bookings.show');
});


// Payment 
Route::get('/booking/{booking}/pay', [PaymentController::class, 'showBookingPayment'])->name('booking.pay')->middleware('auth');
Route::post('/booking/{booking}/pay', [PaymentController::class, 'processBookingPayment'])->middleware('auth');
Route::get('/payment/success', function () {
    return view('user.payment-success');
})->name('payment.success');

Route::get('/user/payment-history', [PaymentController::class, 'paymentHistory'])
    ->name('user.paymentHistory')
    ->middleware('auth');


require __DIR__ . '/auth.php';
