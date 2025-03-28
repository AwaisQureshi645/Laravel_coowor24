<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::orderBy('branch_name')->get();
        $query = Ticket::with('branch');

        // Apply branch filter
        if ($request->has('branch_id') && $request->branch_id != '') {
            $query->where('branch_id', $request->branch_id);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('tickets.index', compact('tickets', 'branches'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('tickets.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'branch_id' => 'required|exists:branch_details,branch_id',
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

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $branches = Branch::orderBy('branch_name')->get();

        return view('tickets.edit', compact('ticket', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'priority' => 'required|in:1,2,3',
            'closeup_date' => 'required|date',
            'assign_to' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $ticket->update($request->all());

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
