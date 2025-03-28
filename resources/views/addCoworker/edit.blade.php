@extends('layouts.app')

@section('content')
<div class="container">
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
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
    <h2>Edit Coworker</h2>

    <form action="{{ route('coworkers.update', $coworker->coworker_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $coworker->name }}" required>
        </div>

        <div class="form-group">
            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" class="form-control" value="{{ $coworker->contact_info }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $coworker->email }}" required>
        </div>

        <div class="form-group">
            <label for="branch_id">Branch:</label>
            <select id="branch_id" name="branch_id" class="form-control" required>
                @foreach($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ $coworker->branch_id == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="seat_type">Seat Type:</label>
            <select id="seat_type" name="seat_type" class="form-control" required>
                <option value="dedicated_seat" {{ $coworker->seat_type == 'dedicated_seat' ? 'selected' : '' }}>Dedicated Seat</option>
                <option value="private_office" {{ $coworker->seat_type == 'private_office' ? 'selected' : '' }}>Private Office</option>
            </select>
        </div>

        <div class="form-group">
            <label for="private_office_size">Private Office Size:</label>
            <input type="text" id="private_office_size" name="private_office_size" class="form-control" value="{{ $coworker->private_office_size }}">
        </div>

        <div class="form-group">
            <label for="no_of_seats">Number of Seats:</label>
            <input type="number" id="no_of_seats" name="no_of_seats" class="form-control" value="{{ $coworker->no_of_seats }}">
        </div>

        <div class="form-group">
            <label for="joining_date">Joining Date:</label>
            <input type="date" id="joining_date" name="joining_date" class="form-control" value="{{ $coworker->joining_date }}">
        </div>

        <div class="form-group">
            <label for="contract_copy">Contract Copy:</label>
            <input type="file" id="contract_copy" name="contract_copy" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
       
    </form>
</div>
@endsection
