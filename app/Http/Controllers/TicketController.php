<?php

namespace App\Http\Controllers;



use App\Models\Ticket;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('tickets.create', compact('branches'));
    }

    public function index()
    {
        $tickets = Ticket::with('branch')->get();
        return view('tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'branch_id' => 'required|exists:branches_details,branch_id',
            'priority' => 'required|in:1,2,3',
            'closeup_date' => 'required|date',
            'assign_to' => 'required|string|max:255',
        ]);

        $data = $request->only([
            'subject', 'description', 'branch_id',
            'priority', 'closeup_date', 'assign_to',
        ]);

        $data['created_by'] = "Awais";
        $data['status'] = 'Pending';

        Ticket::create($data);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }
}

