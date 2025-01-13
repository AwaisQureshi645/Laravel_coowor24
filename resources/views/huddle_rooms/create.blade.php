@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Huddle Room</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('huddle_rooms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Huddle Room Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="branch_id">Select Branch:</label>
            <select id="branch_id" name="branch_id" class="form-control" required>
                <option value="">--Select Branch--</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
