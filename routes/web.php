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
use App\Http\Controllers\CoworkerUserController;
use App\Http\Controllers\CoworkerEmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleCalendarController;

// If it doesn't exist, create the class in the specified namespace

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');
});


// Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
// Route::get('/', function () {
//     return view('dashboard.index');
//     // return redirect()->route('login');
// });


Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


// Route::get('/', [DashboardController::class, 'welcome'])->name('dashboard.index');
//  Route::get('/dashboard', [DashboardController::class, 'welcome'])->name('dashboard.content');

// In routes/web.php


Route::get('/dashboard', function () {
    return view('welcome');
});
// In routes/web.php

Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::get('/visit/create', [VisitController::class, 'create'])->name('visitors.create');
Route::post('/visit', [VisitController::class, 'store'])->name('visitors.store');
Route::get('/visitors/{id}/edit', [VisitController::class, 'edit'])->name('visitors.edit');
Route::delete('/visitors/{id}', [VisitController::class, 'destroy'])->name('visitors.destroy');
Route::put('/visitors/{id}', [VisitController::class, 'update'])->name('visitors.update');

// Individual Coworker Routes
Route::get('/addcoworker/display', [IndividualCoworkerController::class, 'index'])->name('addCoworker.display');
Route::get('/addcoworker', function () {
    return view('addCoworker.index');
});
// Route::get('/addcoworker', [IndividualCoworkerController::class, 'create'])->name('addCoworker.individual');
Route::post('/coworkers', [IndividualCoworkerController::class, 'store'])->name('coworkers.store');
Route::delete('/coworkers/{coworker_id}', [IndividualCoworkerController::class, 'destroy'])->name('coworkers.destroy');
Route::get('/coworkers/{coworker_id}/edit', [IndividualCoworkerController::class, 'edit'])->name('coworkers.edit');
Route::put('/coworkers/{coworker_id}', [IndividualCoworkerController::class, 'update'])->name('coworkers.update');
Route::get('/coworkers/create', [IndividualCoworkerController::class, 'create'])->name('coworkers.create');



// seat management
Route::get('/seats', [SeatController::class, 'index'])->name('seats.index');
Route::get('/seats/fetch', [SeatController::class, 'fetchSeats'])->name('seats.fetch');
Route::post('/seats/add', [SeatController::class, 'addSeat'])->name('seats.add');
Route::post('/seats/delete', [SeatController::class, 'deleteSeat'])->name('seats.delete');
Route::post('/seats/update', [SeatController::class, 'updateSeat'])->name('seats.update');
Route::get('/seats/coworkers', [SeatController::class, 'fetchCoworkers'])->name('seats.fetchCoworkers');









// add team
Route::get('/team-bookings', [TeamBookingController::class, 'index'])->name('teamBookings.index');
Route::get('/team-bookings/create', [TeamBookingController::class, 'create'])->name('teamBookings.create');
Route::post('/team-bookings', [TeamBookingController::class, 'store'])->name('teamBookings.store');
Route::get('/team-bookings/{id}/edit', [TeamBookingController::class, 'edit'])->name('teamBookings.edit');
Route::put('/team-bookings/{id}', [TeamBookingController::class, 'update'])->name('teamBookings.update');
Route::delete('/team-bookings/{id}', [TeamBookingController::class, 'destroy'])->name('teamBookings.destroy');







// create ticket
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

// for branches
Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
Route::get('/branches/create', [BranchController::class, 'create'])->name('branches.create');
Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
Route::get('/branches/{branch:branch_id}/edit', [BranchController::class, 'edit'])->name('branches.edit');
Route::put('/branches/{branch:branch_id}', [BranchController::class, 'update'])->name('branches.update');
Route::delete('/branches/{branch:branch_id}', [BranchController::class, 'destroy'])->name('branches.destroy');

// for officeþ

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

// coworker users routes
Route::get('/coworkerusers', [CoworkerUserController::class, 'index'])->name('coworkerusers.index');
Route::get('/coworkerusers/create', [CoworkerUserController::class, 'create'])->name('coworkerusers.create');
Route::post('/coworkerusers', [CoworkerUserController::class, 'store'])->name('coworkerusers.store');
Route::get('/coworkerusers/{coworker_users_id}/edit', [CoworkerUserController::class, 'edit'])->name('coworkerusers.edit');
Route::put('/coworker-users/{coworker_user}', [CoworkerUserController::class, 'update'])->name('coworkusers.update');
Route::put('/coworkerusers/{coworker_users_id}', [CoworkerUserController::class, 'update'])->name('coworkerusers.update');
Route::delete('/coworkerusers/{coworker_users_id}', [CoworkerUserController::class, 'destroy'])->name('coworkerusers.destroy');


// employee
Route::get('/employees', [CoworkerEmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [CoworkerEmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [CoworkerEmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{coworker_employees_id}/edit', [CoworkerEmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{coworker_employees_id}', [CoworkerEmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{coworker_employees_id}', [CoworkerEmployeeController::class, 'destroy'])->name('employees.destroy');



// calender routes
// Calendar routes - all with 'calendar.' prefix
Route::get('/bookings', [GoogleCalendarController::class, 'index'])->name('calendar.index');
Route::get('/rooms', [GoogleCalendarController::class, 'getRooms'])->name('calendar.rooms');
Route::get('/team-contact', [GoogleCalendarController::class, 'getTeamContact'])->name('calendar.team-contact');
Route::post('/check-availability', [GoogleCalendarController::class, 'checkAvailability'])->name('calendar.check-availability');
Route::post('/save-booking', [GoogleCalendarController::class, 'saveBooking'])->name('calendar.save-booking');
Route::post('/delete-booking', [GoogleCalendarController::class, 'deleteBooking'])->name('calendar.delete-booking');
Route::get('/create-event', [GoogleCalendarController::class, 'createEventForm'])->name('calendar.create-event');
Route::get('/branch-teams', [GoogleCalendarController::class, 'getTeamsByBranch'])->name('calendar.branch-teams');
Route::get('/bookings/{booking:booking_id}/edit', [GoogleCalendarController::class, 'editBooking'])->name('calendar.edit');
Route::put('/bookings/{booking:booking_id}', [GoogleCalendarController::class, 'updateBooking'])->name('calendar.update');
Route::post('/update-booking', [GoogleCalendarController::class, 'updateBooking'])->name('calendar.update-booking');
