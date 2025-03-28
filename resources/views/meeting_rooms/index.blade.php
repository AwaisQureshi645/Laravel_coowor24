@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Meeting Rooms</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="button_with_filter_controller">
        <div class="button_contoll_width">
            <a href="{{ route('offices.create') }}" class="btn btn-primary mb-3">
                <button>
                    Add New Office
                </button>
            </a>
        </div>
        <div class="controls filter_containers   mb-3">
            <form id="branchFilterForm" action="{{ route('meeting_rooms.index') }}" method="GET" class="">
                <label for="branch_id" class="mr-2"></label>
                <select name="branch_id" id="branch_id" class="form-control w-25 mr-2" onchange="this.form.submit()">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ $branchId == $branch->branch_id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                    @endforeach
                </select>
                @if($branchId)
                <!-- <a href="{{ route('visits.index') }}" class="btn btn-danger ml-2">Clear</a> -->
                @endif
            </form>
        </div>
    </div>


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
            @forelse ($meetingRooms as $room)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $room->name }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ $room->branch->branch_name ?? 'N/A' }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('meeting_rooms.edit', $room->id) }}" class="btn btn-primary">
                            <button>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </a>
                        <form action="{{ route('meeting_rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No meeting rooms found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection