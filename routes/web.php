<?php

use App\Http\Controllers\Agents\AgentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\providers\ProviderController;
use App\Http\Controllers\Trips\TripController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Requestes\TripRequestController;
//Route::get('/', function () {
//    return view('welcome');
//});
//

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('auth.login');
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// تسجيل خروج لكل مستخدم (Admin, Provider, Agent)
    Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
    Route::post('/provider/logout', [AuthenticatedSessionController::class, 'destroy'])->name('provider.logout');
    Route::post('/agent/logout', [AuthenticatedSessionController::class, 'destroy'])->name('agent.logout');


    Route::middleware('auth:admin')->group(function () {
        Route::get('/requests', [TripRequestController::class, 'tripRequests'])->name('requests');

        Route::get('/admin/dashboard', function () {
            return view('Dashboard.admin.index');
        })->name('admin.dashboard');
    });

    Route::middleware('auth:provider')->group(function () {
        Route::get('/provider/requests', [ProviderController::class, 'tripRequests'])->name('provider.requests');

        Route::get('/provider/dashboard', function () {
            return view('Dashboard.provider.index');
        })->name('provider.dashboard');
    });

    Route::middleware('auth:agent')->group(function () {
        Route::get('/trips/request/{trip_id}', [AgentController::class, 'requestTrip'])->name('trip.request');
        Route::post('/agent/requests/store', [AgentController::class, 'storeTripRequest'])->name('agent.storeTripRequest');
        Route::get('/dashboard', )->name('dashboard');

        Route::get('/agent/dashboard',[AgentController::class, 'dashboard'])->name('agent.dashboard');
    });

    Route::middleware('auth.multi')->group(function () {
        Route::resource('agents', AgentController::class);
        Route::resource('providers', ProviderController::class);
        Route::resource('trips', TripController::class)->except(['show']);

        Route::post('/trip/accept/{trip_id}/{agent_id}', [TripController::class, 'acceptTrip'])->name('trip.accept');
        Route::get('/notifications', [NotificationController::class, 'fetch'])->name('notifications.fetch');
        Route::get('/notifications/all', [NotificationController::class, 'notifications_all'])->name('notifications.all');
        Route::get('/my-requests', [AgentController::class, 'myRequests'])->name('agent.requests');
        Route::patch('/provider/approve/{request_id}', [ProviderController::class, 'approveRequest'])->name('provider.approveRequest');
        Route::patch('/provider/requests/{request_id}/approve', [ProviderController::class, 'approveRequestWaitingPayment'])->name('provider.WaitingPayment');
        Route::patch('/provider/requests/{request_id}/reject', [ProviderController::class, 'rejectRequest'])->name('provider.rejectRequest');
        Route::get('/provider/confirmed-trips', [ProviderController::class, 'confirmedTrips'])->name('provider.confirmedTrips');
        Route::get('/provider/rejected-trips', [ProviderController::class, 'rejectedTrips'])->name('provider.rejectedTrips');
        Route::get('/agent/confirmed-trips', [AgentController::class, 'confirmedTrips'])->name('agent.confirmedTrips');
        Route::get('/agent/rejected-trips', [AgentController::class, 'rejectedTrips'])->name('agent.rejectedTrips');




        Route::get('/trips/provider-approved', [TripRequestController::class, 'providerApprovedTrips'])->name('trips.providerApproved');
        Route::post('/trips/upload-payment/{trip_id}', [TripRequestController::class, 'uploadPaymentProof'])->name('trips.uploadPayment');


        Route::get('/provider/WatingConfirm', [ProviderController::class, 'TripsWatingConfirm'])->name('WatingConfirm.requests');



        Route::get('/agent/bookings', [TripRequestController::class, 'showBookings'])->name('agent.bookings');
        Route::patch('/agent/requests/{request_id}/confirm', [AgentController::class, 'confirmTrip'])->name('agent.confirmTrip');
        Route::get('/agent/requests/{request_id}/cancel', [AgentController::class, 'cancelTrip'])->name('agent.cancelTrip');

        Route::get('/trips/details/{id}', [TripRequestController::class, 'showTripDetails'])->name('trips.details');



        Route::get('/trips/download-pdf/{id}', [TripController::class, 'downloadPDF'])->name('trips.downloadPDF');


        Route::get('/notifications/mark-as-read/{id}', [NotificationController::class, 'Read'])
            ->name('notifications.markAsRead');

        Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.markAllAsRead');

        Route::get('/agents/profile/{id}', [AgentController::class, 'showProfile'])->name('agents.profile');
        Route::get('/providers/profile/{id}', [ProviderController::class, 'showProfile'])->name('providers.profile');




    });

});


