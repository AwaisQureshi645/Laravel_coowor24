@extends('layouts.app')

@section('content')
<div class="form_container">
    <h1>Enter Team Details</h1>

    <!-- Display Success or Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('teamBookings.store') }}">
        @csrf

        <div class="form-group">
            <label for="team_name">Team Name:</label>
            <input type="text" id="team_name" name="team_name" class="form-control" value="{{ old('team_name') }}" required>
        </div>

        <div class="form-group">
            <label for="joining_date">Joining Date:</label>
            <input type="date" id="joining_date" name="joining_date" class="form-control" value="{{ old('joining_date') }}" required>
        </div>

        <div class="form-group">
            <label for="ending_date">Ending Date:</label>
            <input type="date" id="ending_date" name="ending_date" class="form-control" value="{{ old('ending_date') }}" required>
        </div>

        <div class="form-group">
            <label for="security_amount">Security Amount:</label>
            <input type="number" id="security_amount" name="security_amount" class="form-control" value="{{ old('security_amount') }}" required>
        </div>

        <div class="form-group">
            <label for="point_of_contact">Point of Contact:</label>
            <textarea id="point_of_contact" name="point_of_contact" class="form-control" required>{{ old('point_of_contact') }}</textarea>
        </div>

        <div class="form-group">
            <label for="num_members">Number of Members:</label>
            <input type="number" id="num_members" name="num_members" class="form-control" value="{{ old('num_members') }}" required>
        </div>

        <div class="form-group">
            <label for="branch_id">Select Branch:</label>
            <select id="branch_id" name="branch_id" class="form-control" required>
                @foreach ($branches as $branch)
                <option value="{{ $branch->branch_id }}" {{ old('branch_id') == $branch->branch_id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="reference">Reference:</label>
            <input type="text" id="reference" name="reference" class="form-control" value="{{ old('reference') }}">
        </div>

        <div class="form-group">
            <label for="contract_copy">Contract Copy (optional):</label>
            <input type="file" id="contract_copy" name="contract_copy" class="form-control" accept=".jpg,.jpeg,.png,.webp,.pdf">
        </div>

        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>
@endsection
