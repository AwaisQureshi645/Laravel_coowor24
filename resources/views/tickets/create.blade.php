@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Ticket</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="branch">Branch:</label>
            <select id="branch" name="branch_id" class="form-control" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="priority">Priority:</label>
            <select id="priority" name="priority" class="form-control" required>
                <option value="1">Urgent</option>
                <option value="2">Normal</option>
                <option value="3">Low</option>
            </select>
        </div>

        <div class="form-group">
            <label for="assign_to">Assign To:</label>
            <input type="text" id="assign_to" name="assign_to" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="closeup_date">Close-up Date:</label>
            <input type="date" id="closeup_date" name="closeup_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Ticket</button>
    </form>
</div>
@endsection
