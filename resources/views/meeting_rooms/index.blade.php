@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Meeting Rooms</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('meeting_rooms.create') }}" class="btn btn-primary mb-3">Add New Meeting Room</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Room Name</th>
                <th>Capacity</th>
                <th>Branch</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($meetingRooms as $room)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->capacity }}</td>
                    <td>{{ $room->branch->branch_name ?? 'N/A' }}</td>
                    <td class="d-flex flex-row">
    <a href="{{ route('meeting_rooms.edit', $room->id) }}" class="btn btn-primary">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <form action="{{ route('meeting_rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</td>

               
               
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
