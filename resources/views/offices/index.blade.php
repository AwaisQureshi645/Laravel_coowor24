@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Offices</h2>

    @if(session('success'))
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
        <form id="branchFilterForm" action="{{ route('offices.index') }}" method="GET" class="">
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

    <!-- display the filter -->

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Room No</th>
            <th>Capacity</th>
            <th>Price</th>
            <th>Branch</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($offices as $office)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $office->RoomNo }}</td>
                <td>{{ $office->capacity }}</td>
                <td>{{ $office->Price }}</td>
                <td>{{ $office->branch->branch_name ?? 'N/A' }}</td>
                <td>{{ $office->status }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('offices.edit', $office->id) }}" class="btn btn-primary">
                            <button>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </a>
                        <form action="{{ route('offices.destroy', $office->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No records found</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection