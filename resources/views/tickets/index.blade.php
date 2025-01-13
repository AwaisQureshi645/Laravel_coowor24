@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tickets</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Branch</th>
                <th>Priority</th>
                <th>Close-up Date</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->subject }}</td>
                    <td>{{ $ticket->description }}</td>
                    <td>{{ $ticket->branch->branch_name ?? 'N/A' }}</td>
                    <td>
                        @if($ticket->priority == 1)
                            Urgent
                        @elseif($ticket->priority == 2)
                            Normal
                        @elseif($ticket->priority == 3)
                            Low
                        @endif
                    </td>
                    <td>{{ $ticket->closeup_date }}</td>
                    <td>{{ $ticket->assign_to }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->created_by }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No tickets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
