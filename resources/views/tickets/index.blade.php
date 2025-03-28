@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tickets</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter -->
    <div class="controls filter_containers  mb-3">
    <form method="GET" action="{{ route('tickets.index') }}" class="mb-4">
        <div class="form-group">
            <label for="branch_id"></label>
            <select id="branch_id" name="branch_id" class="form-control" onchange="this.form.submit()">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ request('branch_id') == $branch->branch_id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    </div>

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
                <th>Actions</th>
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
                        @if($ticket->priority == 1) Urgent
                        @elseif($ticket->priority == 2) Normal
                        @elseif($ticket->priority == 3) Low
                        @endif
                    </td>
                    <td>{{ $ticket->closeup_date }}</td>
                    <td>{{ $ticket->assign_to }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>
                        <div class='btn-group'>

                       
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">
                        <button>
                                <i class='fa-solid fa-pen-to-square'></i>
                                </button>  
                        </a>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">   <i class='fa-solid fa-trash'></i></button>
                        </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No tickets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
