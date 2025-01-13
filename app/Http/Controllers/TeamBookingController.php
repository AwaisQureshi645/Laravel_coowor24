<?php

namespace App\Http\Controllers;

use App\Models\TeamBooking;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamBookingController extends Controller
{
    public function index()
    {
        $teamBookings = TeamBooking::with('branch')->get();
        return view('teamBookings.index', compact('teamBookings'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
    return view('teamBookings.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_name' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'ending_date' => 'required|date|after:joining_date',
            'security_amount' => 'required|numeric',
            'point_of_contact' => 'required|string',
            'num_members' => 'required|integer',
            'branch_name' => 'required|exists:branches,branch_name',
            'reference' => 'nullable|string|max:255',
            'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        
        if ($request->hasFile('contract_copy')) {
            $filePath = $request->file('contract_copy')->store('contracts', 'public');
            $validated['contract_copy'] = $filePath;
        }

        TeamBooking::create($validated);

        return redirect()->route('teamBookings.index')->with('success', 'Team booking added successfully.');
    }

    public function edit($id)
    {
        $teamBooking = TeamBooking::findOrFail($id);
        $branches = Branch::orderBy('branch_name')->get();
        return view('teamBookings.edit', compact('teamBooking', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $teamBooking = TeamBooking::findOrFail($id);

        $validated = $request->validate([
            'team_name' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'ending_date' => 'required|date|after:joining_date',
            'security_amount' => 'required|numeric',
            'point_of_contact' => 'required|string',
            'num_members' => 'required|integer',
            'branch_id' => 'required|exists:branches,id',
            'reference' => 'nullable|string|max:255',
            'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        if ($request->hasFile('contract_copy')) {
            if ($teamBooking->contract_copy) {
                Storage::disk('public')->delete($teamBooking->contract_copy);
            }
            $filePath = $request->file('contract_copy')->store('contracts', 'public');
            $validated['contract_copy'] = $filePath;
        }

        $teamBooking->update($validated);

        return redirect()->route('teamBookings.index')->with('success', 'Team booking updated successfully.');
    }

    public function destroy($id)
    {
        $teamBooking = TeamBooking::findOrFail($id);

        if ($teamBooking->contract_copy) {
            Storage::disk('public')->delete($teamBooking->contract_copy);
        }

        $teamBooking->delete();

        return redirect()->route('teamBookings.index')->with('success', 'Team booking deleted successfully.');
    }
}
