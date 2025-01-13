@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Office</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offices.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="RoomNo">Room Number:</label>
            <input type="text" id="RoomNo" name="RoomNo" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Price">Price:</label>
            <input type="number" step="0.01" id="Price" name="Price" class="form-control" required>
        </div>

        <div class="form-group">
    <label for="branch_id">Select Branch:</label>
    <select id="branch_id" name="branch_id" class="form-control" >
        <option value="">Select a branch</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
        @endforeach
      
    </select>
</div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="Available">Available</option>
                <option value="Not Available">Not Available</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('offices.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
