@extends('layouts.app')

@section('content')
<div class="container">
    <div class="button_contoll_width_back">
        <a href="{{ route('visits.index') }}" class="btn btn-secondary">
            <button>
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </a>
    </div>
    <h2>Add New Visitor Record</h2>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('visitors.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="phonenumber" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for="businessDetails" class="form-label">Business Details</label>
            <input type="text" class="form-control" id="businessDetails" name="businessDetails" required>
        </div>

        <div class="mb-3">
            <label for="branch_id" class="form-label">Branch</label>
            <select class="form-control" id="branch_id" name="branch_id" required>
                <option value="">Select a branch</option>
                @foreach ($branches as $branch)
                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="assignedTo" class="form-label">Assigned To</label>
            <input type="text" class="form-control" id="assignedTo" name="assignedTo">
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" id="comment" name="Comments" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="purpose" class="form-label">Purpose</label>
            <input type="text" class="form-control" id="purpose" name="purpose" required>
        </div>

        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required onclick=this.showPicker()>
        </div>

        <div class="d-flex justify-content-between">
            <!-- <a href="{{ url('/') }}" class="btn btn-secondary">Cancel</a> -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection