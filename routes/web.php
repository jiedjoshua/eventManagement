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
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ManagerFeedbackController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\EventAdminController;
use App\Http\Controllers\HomePageController;


Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/packages', [HomePageController::class, 'packages'])->name('packages');

Route::get('/gallery', [HomePageController::class, 'gallery'])->name('gallery');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('users', SuperAdminController::class);
    Route::get('/admin/dashboard', [SuperAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [SuperAdminController::class, 'listUsers'])->name('admin.listusers');
    Route::post('/admin/users', [SuperAdminController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [SuperAdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [SuperAdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}', [SuperAdminController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [SuperAdminController::class, 'edit'])->name('admin.users.edit');

    // CMS Routes
    Route::get('/admin/cms/home-page', [HomePageController::class, 'manage'])->name('admin.cms.home-page');
    Route::post('/admin/cms/hero/update', [HomePageController::class, 'updateHero'])->name('admin.cms.hero.update');
    Route::post('/admin/cms/services/update', [HomePageController::class, 'updateServices'])->name('admin.cms.services.update');
    Route::post('/admin/cms/about/update', [HomePageController::class, 'updateAbout'])->name('admin.cms.about.update');
    Route::post('/admin/cms/contact/update', [HomePageController::class, 'updateContact'])->name('admin.cms.contact.update');
    Route::post('/admin/cms/section/toggle', [HomePageController::class, 'toggleSection'])->name('admin.cms.section.toggle');

    // Services Page CMS Routes
    Route::get('/admin/cms/services-page', [HomePageController::class, 'manageServicesPage'])->name('admin.cms.services-page');
    Route::post('/admin/cms/services-page/hero/update', [HomePageController::class, 'updateServicesHero'])->name('admin.cms.services-page.hero.update');
    Route::post('/admin/cms/services-page/services/update', [HomePageController::class, 'updateServicesPageServices'])->name('admin.cms.services-page.services.update');
    Route::post('/admin/cms/services-page/coming-soon/update', [HomePageController::class, 'updateServicesComingSoon'])->name('admin.cms.services-page.coming-soon.update');
    Route::post('/admin/cms/services-page/why-choose/update', [HomePageController::class, 'updateServicesWhyChooseUs'])->name('admin.cms.services-page.why-choose.update');
    Route::post('/admin/cms/services-page/cta/update', [HomePageController::class, 'updateServicesCTA'])->name('admin.cms.services-page.cta.update');

    // Packages Page CMS Routes
    Route::get('/admin/cms/packages-page', [HomePageController::class, 'managePackagesPage'])->name('admin.cms.packages-page');
    Route::post('/admin/cms/packages-page/hero/update', [HomePageController::class, 'updatePackagesHero'])->name('admin.cms.packages-page.hero.update');
    Route::post('/admin/cms/packages-page/{type}/update', [HomePageController::class, 'updatePackagesType'])->name('admin.cms.packages-page.type.update');

    // Gallery Page CMS Routes
    Route::get('/admin/cms/gallery-page', [HomePageController::class, 'manageGalleryPage'])->name('admin.cms.gallery-page');
    Route::post('/admin/cms/gallery-page/hero/update', [HomePageController::class, 'updateGalleryHero'])->name('admin.cms.gallery-page.hero.update');
    Route::post('/admin/cms/gallery-page/images/update', [HomePageController::class, 'updateGalleryImages'])->name('admin.cms.gallery-page.images.update');
    Route::post('/admin/cms/gallery-page/cta/update', [HomePageController::class, 'updateGalleryCTA'])->name('admin.cms.gallery-page.cta.update');

    // About Page CMS Routes
    Route::get('/admin/cms/about-page', [HomePageController::class, 'manageAboutPage'])->name('admin.cms.about-page');
    Route::post('/admin/cms/about-page/hero/update', [HomePageController::class, 'updateAboutHero'])->name('admin.cms.about-page.hero.update');
    Route::post('/admin/cms/about-page/story/update', [HomePageController::class, 'updateAboutStory'])->name('admin.cms.about-page.story.update');
    Route::post('/admin/cms/about-page/mission-vision/update', [HomePageController::class, 'updateAboutMissionVision'])->name('admin.cms.about-page.mission-vision.update');
    Route::post('/admin/cms/about-page/values/update', [HomePageController::class, 'updateAboutValues'])->name('admin.cms.about-page.values.update');
    Route::post('/admin/cms/about-page/stats/update', [HomePageController::class, 'updateAboutStats'])->name('admin.cms.about-page.stats.update');
    Route::post('/admin/cms/about-page/cta/update', [HomePageController::class, 'updateAboutCTA'])->name('admin.cms.about-page.cta.update');

    // Contact Page CMS Routes
    Route::get('/admin/cms/contact-page', [HomePageController::class, 'manageContactPage'])->name('admin.cms.contact-page');
    Route::post('/admin/cms/contact-page/hero/update', [HomePageController::class, 'updateContactHero'])->name('admin.cms.contact-page.hero.update');
    Route::post('/admin/cms/contact-page/info/update', [HomePageController::class, 'updateContactInfo'])->name('admin.cms.contact-page.info.update');
    Route::post('/admin/cms/contact-page/faq/update', [HomePageController::class, 'updateContactFAQ'])->name('admin.cms.contact-page.faq.update');
    Route::post('/admin/cms/contact-page/cta/update', [HomePageController::class, 'updateContactCTA'])->name('admin.cms.contact-page.cta.update');

    // Package Management Routes
    Route::resource('admin/packages', PackageController::class)->names([
        'index' => 'admin.packages.index',
        'create' => 'admin.packages.create',
        'store' => 'admin.packages.store',
        'edit' => 'admin.packages.edit',
        'update' => 'admin.packages.update',
        'destroy' => 'admin.packages.destroy',
    ]);
    Route::patch('/admin/packages/{package}/toggle-status', [PackageController::class, 'toggleStatus'])->name('admin.packages.toggle-status');

    // Add-on Management Routes
    Route::post('/admin/addons', [AddonController::class, 'store']);
    Route::get('/admin/addons/{addon}/edit', [AddonController::class, 'edit']);
    Route::match(['put', 'patch'], '/admin/addons/{addon}', [AddonController::class, 'update']);
    Route::delete('/admin/addons/{addon}', [AddonController::class, 'destroy']);

    Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
    Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');
    Route::get('/venues/{venue}/edit', [VenueController::class, 'edit'])->name('venues.edit');

    // Admin Venue Routes
    Route::get('/admin/venues', [VenueController::class, 'adminIndex'])->name('admin.venues.index');
    Route::get('/admin/venues/map', [VenueController::class, 'venueMap'])->name('admin.venues.map');
    Route::get('/admin/venue-calendar', [VenueController::class, 'venueCalendar'])->name('admin.venue-calendar');
    Route::get('/admin/venue-calendar/bookings', [VenueController::class, 'getCalendarBookings'])->name('admin.venue-calendar.bookings');
    Route::post('/admin/venues', [VenueController::class, 'store'])->name('admin.venues.store');
    Route::get('/admin/venues/{venue}', [VenueController::class, 'adminShow'])->name('admin.venues.show');
    Route::put('/admin/venues/{venue}', [VenueController::class, 'update'])->name('admin.venues.update');
    Route::delete('/admin/venues/{venue}', [VenueController::class, 'destroy'])->name('admin.venues.destroy');

    // Public venue routes (for API)
    Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
    Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');
    
    // Venue unavailability management routes
    Route::post('/api/venues/mark-unavailable', [VenueController::class, 'markUnavailable'])->name('api.venues.mark-unavailable');
    Route::delete('/api/venues/remove-unavailability', [VenueController::class, 'removeUnavailability'])->name('api.venues.remove-unavailability');

    Route::get('/admin/account-settings', [SuperAdminController::class, 'accountSettings'])->name('admin.account-settings');

    // Event Management Routes
    Route::resource('admin/events', EventAdminController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/api/venues/check-availability', [VenueController::class, 'checkAvailability'])->name('api.venues.check-availability');
    Route::get('/api/venues/unavailabilities', [VenueController::class, 'getUnavailabilities'])->name('api.venues.unavailabilities');
    Route::get('/api/venues/bookings', [VenueController::class, 'getVenueBookings'])->name('api.venues.bookings');
});
Route::middleware(['auth', 'role:event_manager', 'prevent-back-history'])->group(function () {
    Route::get('/manager/dashboard', [EventManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/manage/events', [EventManagerController::class, 'showEvent'])->name('manager.showEvent');

    Route::get('/manager/upcoming-events', [EventManagerController::class, 'upcomingEvents'])->name('manager.upcomingEvents');
    Route::get('/manager/events/{event}/details', [EventManagerController::class, 'details'])->name('events.details');
    Route::patch('/manager/events/{event}/reschedule', [EventManagerController::class, 'reschedule'])->name('manager.events.reschedule');
    Route::post('/manager/events/{event}/end', [EventManagerController::class, 'endEvent'])->name('manager.events.end');

    Route::get('/events/{event}/dashboard', [EventController::class, 'showDashboard'])->name('events.dashboard');
    Route::get('/events/{event}/qrscanner', [EventController::class, 'showQRScanner'])->name('events.qrScanner');
    Route::get('/events/{event}/guests', [EventController::class, 'showGuestList'])->name('events.guests');
    Route::get('/events/{event}/checkedin', [EventController::class, 'showCheckedInList'])->name('events.checkedIn');
    Route::get('/checkin/scan', [EventController::class, 'scanCheckIn'])->name('checkin.scan');
    Route::get('/events/{event}/manual-checkin', [EventController::class, 'showManualCheckin'])->name('events.manualCheckin');
    Route::get('/events/{event}/search-guests', [EventController::class, 'searchGuests'])->name('events.searchGuests');
    Route::get('/events/{event}/all-guests', [EventController::class, 'getAllGuests'])->name('events.getAllGuests');
    Route::post('/events/{event}/check-in/{guestId}', [EventController::class, 'manualCheckIn'])->name('events.manualCheckIn');
    
    Route::patch('/manager/events/{event}/cancel', [EventManagerController::class, 'cancelEvent'])->name('manager.events.cancel');

    Route::get('/manager/account-settings', [EventManagerController::class, 'accountSettings'])->name('manager.account-settings');

    // Booking Management
    Route::get('/manager/booked-events', [EventManagerController::class, 'showBooked'])->name('manager.bookedEvents');
    Route::patch('/manager/bookings/{booking}/approve', [EventManagerController::class, 'approve'])->name('manager.approveBooking');
    Route::patch('/manager/bookings/{booking}/reject', [EventManagerController::class, 'reject'])->name('manager.rejectBooking');
    Route::get('/manager/bookings/{booking}/details', [EventManagerController::class, 'getDetails']);

    Route::get('/manager/guest-lists', [EventManagerController::class, 'showGuestLists'])->name('manager.guestLists');
    Route::get('/manager/events/{event}/guests', [EventManagerController::class, 'guests'])->name('manager.event.guests');

    Route::get('/manager/generate-external-qr-codes', [EventManagerController::class, 'showGenerateExternalQRCodes'])->name('manager.showGenerateExternalQRCodes');
    Route::post('/manager/generate-external-qr-codes', [EventController::class, 'generateExternalQRCodes'])->name('manager.generateExternalQRCodes');

    // Event CRUD operations
    Route::put('/manager/events/{event}', [EventManagerController::class, 'updateEvent'])->name('manager.events.update');
    Route::delete('/manager/events/{event}', [EventManagerController::class, 'deleteEvent'])->name('manager.events.delete');

    // Manager Venue Routes (View Only)
    Route::get('/manager/venues', [VenueController::class, 'managerVenues'])->name('manager.venues');
    Route::get('/manager/venues/calendar', [VenueController::class, 'managerVenueCalendar'])->name('manager.venue-calendar');
    Route::get('/manager/venues/map', [VenueController::class, 'managerVenueMap'])->name('manager.venue-map');
    Route::get('/manager/venues/{id}', [VenueController::class, 'showVenue'])->name('manager.venue.show');
    Route::get('/manager/venue-calendar/bookings', [VenueController::class, 'getManagerCalendarBookings'])->name('manager.venue-calendar.bookings');

    Route::get('/manager/feedback-analytics', [ManagerFeedbackController::class, 'analytics'])->name('manager.feedback.analytics');
    Route::get('/manager/events/{event}/feedbacks', [ManagerFeedbackController::class, 'eventFeedbacks'])->name('manager.event.feedbacks');
    Route::get('/manager/event-summary', [ManagerFeedbackController::class, 'eventSummary'])->name('manager.event.summary');
    
    // Payment History
    Route::get('/manager/payment-history', [EventManagerController::class, 'paymentHistory'])->name('manager.paymentHistory');
    Route::get('/manager/refund-history', [EventManagerController::class, 'refundHistory'])->name('manager.refundHistory');

    // Ended Events & Feedbacks
    Route::get('/manager/ended-events', [EventManagerController::class, 'endedEventsWithFeedback'])->name('manager.endedEvents');
    Route::get('/manager/ended-events/ajax', [EventManagerController::class, 'ajaxEndedEventsWithFeedback'])->name('manager.endedEvents.ajax');
    Route::get('/manager/ended-events/{event}/feedbacks', [EventManagerController::class, 'showEventFeedbacks'])->name('manager.eventFeedbacks');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/events/booked', [UserController::class, 'bookedEvents'])->name('user.bookedEvents');

    Route::get('user/bookings/{reference}/edit', [UserController::class, 'editBooking'])->name('bookings.edit');
    Route::post('user/bookings/{reference}/update', [UserController::class, 'updateBooking'])->name('bookings.update');
    Route::get('/user/payments', [UserController::class, 'payments'])->name('user.payments');
    Route::get('/user/account-settings', [UserController::class, 'showAccountSettings'])->name('user.accountSettings');
    Route::get('user/events/{event}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('user/events/{event}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/user/bookings/{reference}/guest-list', [UserController::class, 'showGuestList'])->name('user.guest-list');
});

// User cancellation route without middleware restrictions
Route::post('user/bookings/{reference}/cancel', [UserController::class, 'cancelBooking'])->name('user.bookings.cancel')->middleware('auth');
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
    return view('user.payment.payment-success');
})->name('payment.success');

Route::get('/user/payment-history', [PaymentController::class, 'paymentHistory'])
    ->name('user.paymentHistory')
    ->middleware('auth');

require __DIR__ . '/auth.php';
