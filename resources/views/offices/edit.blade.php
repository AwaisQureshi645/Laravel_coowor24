@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Office</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offices.update', $office->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="RoomNo" class="form-label">Room No</label>
            <input type="text" class="form-control" id="RoomNo" name="RoomNo" value="{{ $office->RoomNo }}" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $office->capacity }}" required>
        </div>

        <div class="mb-3">
            <label for="Price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="Price" name="Price" value="{{ $office->Price }}" required>
        </div>

        <div class="mb-3">
            <label for="branch_id" class="form-label">Branch</label>
            <select class="form-control" id="branch_id" name="branch_id" required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ $office->branch_id == $branch->branch_id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Available" {{ $office->status == 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Not Available" {{ $office->status == 'Not Available' ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Office</button>
    </form>
</div>
@endsection
