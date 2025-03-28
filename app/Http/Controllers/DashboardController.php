<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BranchDetails; // This import is missing
use App\Models\Seat; // Correct import statement
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Booking; // This import is missing
use App\Models\CoworkerUser as User;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get all branches with seat counts
        $branches = BranchDetails::withCount([
            'seats as available_seats' => function ($query) {
                $query->where('status', 'available');
            },
            'seats as occupied_seats' => function ($query) {
                $query->where('status', 'occupied');
            },
            'seats as total_seats'
        ])->get();

        $bookingsCount = Booking::count();
        $userCount = User::count();
       
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('username', Auth::user()->name);
            }
        });

        return view('dashboard.index', [
            'created_by' => Auth::user()->name,
            'branches' => $branches,
            'bookingsCount' => $bookingsCount,
            'userCount' => $userCount
        ]);
    }
    
    // public function index()
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login');
    //     }

    //     // Get all branches with seat counts
    //     $branches = BranchDetails::withCount([
    //         'seats as available_seats' => function ($query) {
    //             $query->where('status', 'available');
    //         },
    //         'seats as occupied_seats' => function ($query) {
    //             $query->where('status', 'occupied');
    //         },
    //         'seats as total_seats'
    //     ])->get();

    //     $bookingsCount = Booking::count();

    //     return view('dashboard.index', [
    //         'created_by' => Auth::user()->name, 
    //         'branches' => $branches, 
    //         'bookingsCount' => $bookingsCount
    //     ]);
    // }
    public function welcome()
    {
        try {
            Log::info('Fetching all branches...');
            // Fetch branches from branch_details table (as shown in Image 1)
            $branches = DB::table('branch_details')->get();
            Log::info('Branches fetched', ['count' => count($branches)]);

            Log::info('Fetching seat counts...');
            // Query using column names from seats table (as shown in Image 2)
            $seatCounts = DB::table('seats')
                ->selectRaw('branch_id, status, COUNT(*) as count')
                ->groupBy('branch_id', 'status')
                ->get();
            Log::info('Seat counts fetched', ['data' => $seatCounts->toArray()]);

            $branchStats = [];
            $totalAvailable = 0;
            $totalOccupied = 0;

            foreach ($branches as $branch) {
                $available = 0;
                $occupied = 0;

                foreach ($seatCounts as $count) {
                    if ($count->branch_id == $branch->branch_id) { // Using branch_id from branch_details table
                        if ($count->status == 'available') {
                            $available = $count->count;
                            $totalAvailable += $available;
                        } elseif ($count->status == 'occupied') {
                            $occupied = $count->count;
                            $totalOccupied += $occupied;
                        }
                    }
                }

                $branchStats[$branch->branch_id] = [
                    'available' => $available,
                    'occupied' => $occupied,
                    'total' => $available + $occupied
                ];
            }

            $totalStats = [
                'available' => $totalAvailable,
                'occupied' => $totalOccupied,
                'total' => $totalAvailable + $totalOccupied
            ];

            Log::info('Final Branch Statistics', ['branchStats' => $branchStats]);
            Log::info('Total Seat Statistics', ['totalStats' => $totalStats]);

            return view('dashboard.content', compact('branches',));
        } catch (\Exception $e) {
            Log::error('Error in welcome() method', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }


    public function GetDashboardData()
    {
        try {
            // Fetch branches from branch_details table
            $branches = Branchdetails::orderBy('branch_id')->get();

            // Get the count of bookings
            $bookingsCount = Booking::count();

            return view('dashboard.content', compact('branches', 'bookingsCount'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
    public function welcomeData()
    {
        // Get your data as you do in the welcome method
        $branchData = BranchDetails::all(); // or whatever logic you have
        // $totalEmployees = Employee::count();
        $activeBookings = Booking::where('status', 'active')->count();
        // Get any other data you need

        // Return just the data, not the view
        return [
            'branchData' => $branchData,
            'activeBookings' => $activeBookings,

        ];
    }
}
