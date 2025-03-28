@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex justify-between items-center">
        <div class="button_contoll_width_back">
            <a href="{{ route('meeting_rooms.index') }}" class="btn btn-secondary">
                <button>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </a>
        </div>
        <h2>Add New Meeting Room</h2>
  
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('meeting_rooms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Meeting Room Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="branch_id">Select Branch:</label>
            <select id="branch_id" name="branch_id" class="form-control" required>
                <option value="">-- Select Branch --</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <!-- <a href="{{ route('meeting_rooms.index') }}" class="btn btn-secondary">Cancel</a> -->
    </form>
</div>
@endsection
