@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Users</h2>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="button_with_filter_controller">
        <div class="button_contoll_width">
            <a href="{{ route('coworkerusers.create') }}" class="btn btn-primary mb-3">
                <button>
                    Add New Office
                </button>
            </a>
        </div>
        <div class="controls filter_containers   mb-3">
            <form id="branchFilterForm" action="{{ route('coworkerusers.index') }}" method="GET" class="">
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
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Branch</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($users->count() > 0)
            @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phonenumber }}</td>
                <td>{{ $user->branch->branch_name ?? 'N/A' }}</td>
                <td>{{ $user->role }}</td>
                <td class="btn-group">
                    <a href="{{ route('coworkerusers.edit', $user->coworker_users_id) }}" class="btn btn-warning">
                        <button> <i class="fa-solid fa-pen-to-square"></i></button>
                    </a>
                    <form action="{{ route('coworkerusers.destroy', $user->coworker_users_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class='fa-solid fa-trash'></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No data found</td>
            </tr>
        @endif
    </tbody>
</table>

<!-- Pagination links -->
{{ $users->appends(request()->query())->links() }}
</div>
@endsection