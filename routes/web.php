<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\VisitorInfoController;
use App\Http\Controllers\IndividualCoworkerController;
use App\Http\Controllers\TeamBookingController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\HuddleRoomController;
// If it doesn't exist, create the class in the specified namespace
Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/dashboard', function () {
    return view('welcome');
});
Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::get('/visit/create', [VisitController::class, 'create'])->name('visitors.create');
Route::post('/visit', [VisitController::class, 'store'])->name('visitors.store');
Route::get('/visitors/{id}/edit', [VisitController::class, 'edit'])->name('visitors.edit');
Route::delete('/visitors/{id}', [VisitController::class, 'destroy'])->name('visitors.destroy');
Route::put('/visitors/{id}', [VisitController::class, 'update'])->name('visitors.update');

Route::get('/addcoworker', function () {
    return view('addCoworker.index');
});
Route::get('/addcoworker/display', [IndividualCoworkerController::class, 'index'])->name('addCoworker.display');
Route::post('/coworkers', [IndividualCoworkerController::class, 'store'])->name('coworkers.store');
Route::delete('/coworkers/{id}', [IndividualCoworkerController::class, 'destroy'])->name('coworkers.destroy');
Route::get('/coworkers/{id}/edit', [IndividualCoworkerController::class, 'edit'])->name('coworkers.edit');
Route::put('/coworkers/{id}', [IndividualCoworkerController::class, 'update'])->name('coworkers.update');



// seat management
Route::get('/seats', [SeatController::class, 'index'])->name('seats.index');
Route::get('/seats/fetch', [SeatController::class, 'fetchSeats'])->name('seats.fetch');
Route::post('/seats/add', [SeatController::class, 'addSeat'])->name('seats.add');
Route::post('/seats/delete', [SeatController::class, 'deleteSeat'])->name('seats.delete');
Route::post('/seats/update', [SeatController::class, 'updateSeat'])->name('seats.update');
Route::get('/seats/branches', [SeatController::class, 'fetchBranches'])->name('seats.fetchBranches');
Route::get('/seats/coworkers', [SeatController::class, 'fetchCoworkers'])->name('seats.fetchCoworkers');










// add team
Route::get('/team-bookings', [TeamBookingController::class, 'index'])->name('teamBookings.index');
Route::get('/team-bookings/create', [TeamBookingController::class, 'create'])->name('teamBookings.create');
Route::post('/team-bookings', [TeamBookingController::class, 'store'])->name('teamBookings.store');
Route::get('/team-bookings/{id}/edit', [TeamBookingController::class, 'edit'])->name('teamBookings.edit');
Route::put('/team-bookings/{id}', [TeamBookingController::class, 'update'])->name('teamBookings.update');
Route::delete('/team-bookings/{id}', [TeamBookingController::class, 'destroy'])->name('teamBookings.destroy');







// create ticket
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

// for branches
Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
Route::get('/branches/create', [BranchController::class, 'create'])->name('branches.create');
Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');

// for office

Route::get('/offices/create', [OfficeController::class, 'create'])->name('offices.create');
Route::post('/offices', [OfficeController::class, 'store'])->name('offices.store');
Route::get('/offices', [OfficeController::class, 'index'])->name('offices.index');
Route::get('/offices/{id}/edit', [OfficeController::class, 'edit'])->name('offices.edit');
Route::put('/offices/{id}', [OfficeController::class, 'update'])->name('offices.update');
Route::delete('/offices/{id}', [OfficeController::class, 'destroy'])->name('offices.destroy');

// for meeting rooms


Route::get('/meeting-rooms', [MeetingRoomController::class, 'index'])->name('meeting_rooms.index');
Route::get('/meeting-rooms/create', [MeetingRoomController::class, 'create'])->name('meeting_rooms.create');
Route::post('/meeting-rooms', [MeetingRoomController::class, 'store'])->name('meeting_rooms.store');
Route::get('/meeting-rooms/{id}/edit', [MeetingRoomController::class, 'edit'])->name('meeting_rooms.edit');
Route::put('/meeting-rooms/{id}', [MeetingRoomController::class, 'update'])->name('meeting_rooms.update');
Route::delete('/meeting-rooms/{id}', [MeetingRoomController::class, 'destroy'])->name('meeting_rooms.destroy');

// for huddle rooms

Route::get('/huddle-rooms', [HuddleRoomController::class, 'index'])->name('huddle_rooms.index');
Route::get('/huddle-rooms/create', [HuddleRoomController::class, 'create'])->name('huddle_rooms.create');
Route::post('/huddle-rooms', [HuddleRoomController::class, 'store'])->name('huddle_rooms.store');
Route::get('/huddle-rooms/{id}/edit', [HuddleRoomController::class, 'edit'])->name('huddle_rooms.edit');
Route::put('/huddle-rooms/{id}', [HuddleRoomController::class, 'update'])->name('huddle_rooms.update');
Route::delete('/huddle-rooms/{id}', [HuddleRoomController::class, 'destroy'])->name('huddle_rooms.destroy');

