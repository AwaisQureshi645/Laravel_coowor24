@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Meeting Room</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('meeting_rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Room Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $room->name }}" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $room->capacity }}" required>
        </div>

        <div class="mb-3">
            <label for="branch_id" class="form-label">Branch</label>
            <select class="form-control" id="branch_id" name="branch_id" required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ $room->branch_id == $branch->branch_id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Room</button>
    </form>
</div>
@endsection
