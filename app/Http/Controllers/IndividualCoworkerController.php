<?php

namespace App\Http\Controllers;

use App\Models\IndividualCoworker;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndividualCoworkerController extends Controller
{
    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('addcoworker.addIndividual', compact('branches'));
    }
    public function index()
    {
        // Fetch all coworkers with branch relationships
        $coworkers = IndividualCoworker::with('branch')->get();

        return view('addCoworker.display', compact('coworkers'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'branch_id' => 'required|exists:branches,id',
            'seat_type' => 'required|in:dedicated_seat,private_office',
            'private_office_size' => 'nullable|in:8_person,16_person,22_person,40_person',
            'no_of_seats' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        if ($request->hasFile('contract_copy')) {
            $filePath = $request->file('contract_copy')->store('contracts', 'public');
            $validated['contract_copy'] = $filePath;
        }

        IndividualCoworker::create($validated);

        return redirect()->route('addCoworker.display')->with('success', 'Coworker added successfully.');
    }
    public function edit($id)
{
    $coworker = IndividualCoworker::findOrFail($id); // Fetch the coworker to edit
    $branches = Branch::orderBy('branch_name')->get(); // Fetch branches for dropdown

    return view('addcoworker.edit', compact('coworker', 'branches')); // Return edit view
}

    public function update(Request $request, $id)
    {
        $coworker = IndividualCoworker::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'branch_id' => 'required|exists:branches,id',
            'seat_type' => 'required|in:dedicated_seat,private_office',
            'private_office_size' => 'nullable|in:8_person,16_person,22_person,40_person',
            'no_of_seats' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        if ($request->hasFile('contract_copy')) {
            if ($coworker->contract_copy) {
                Storage::disk('public')->delete($coworker->contract_copy);
            }
            $filePath = $request->file('contract_copy')->store('contracts', 'public');
            $validated['contract_copy'] = $filePath;
        }

        $coworker->update($validated);

        return redirect()->route('addCoworker.display')->with('success', 'Coworker updated successfully.');
    }

    public function destroy($id)
    {
        $coworker = IndividualCoworker::findOrFail($id);

        if ($coworker->contract_copy) {
            Storage::disk('public')->delete($coworker->contract_copy);
        }

        $coworker->delete();

        return redirect()->route('addCoworker.display')->with('success', 'Coworker deleted successfully.');
    }

    
}
