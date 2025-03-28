@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Ticket</h2>

    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" class="form-control" value="{{ $ticket->subject }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required>{{ $ticket->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="branch_id">Branch</label>
            <select id="branch_id" name="branch_id" class="form-control" required>
                @foreach($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ $ticket->branch_id == $branch->branch_id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="priority">Priority</label>
            <select id="priority" name="priority" class="form-control" required>
                <option value="1" {{ $ticket->priority == 1 ? 'selected' : '' }}>Urgent</option>
                <option value="2" {{ $ticket->priority == 2 ? 'selected' : '' }}>Normal</option>
                <option value="3" {{ $ticket->priority == 3 ? 'selected' : '' }}>Low</option>
            </select>
        </div>

        <div class="form-group">
            <label for="closeup_date">Close-up Date</label>
            <input type="date" id="closeup_date" name="closeup_date" class="form-control" value="{{ $ticket->closeup_date }}" required>
        </div>

        <div class="form-group">
            <label for="assign_to">Assigned To</label>
            <input type="text" id="assign_to" name="assign_to" class="form-control" value="{{ $ticket->assign_to }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" id="status" name="status" class="form-control" value="{{ $ticket->status }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Ticket</button>
    </form>
</div>
@endsection
