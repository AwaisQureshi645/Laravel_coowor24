@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Branch</h2>

    <form action="{{ route('branches.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="branch_name">Branch Name:</label>
            <input type="text" id="branch_name" name="branch_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="contact_details">Contact Details:</label>
            <input type="text" id="contact_details" name="contact_details" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="manager_name">Manager Name:</label>
            <input type="text" id="manager_name" name="manager_name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
