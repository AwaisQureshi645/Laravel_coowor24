@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Branch</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('branches.update', $branch->branch_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="branch_name" class="form-label">Branch Name</label>
            <input type="text" id="branch_name" name="branch_name" class="form-control" value="{{ old('branch_name', $branch->branch_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $branch->location) }}" required>
        </div>

        <div class="mb-3">
            <label for="contact_details" class="form-label">Contact Details</label>
            <input type="text" id="contact_details" name="contact_details" class="form-control" value="{{ old('contact_details', $branch->contact_details) }}" required>
        </div>

        <div class="mb-3">
            <label for="manager_name" class="form-label">Manager Name</label>
            <input type="text" id="manager_name" name="manager_name" class="form-control" value="{{ old('manager_name', $branch->manager_name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Branch</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
