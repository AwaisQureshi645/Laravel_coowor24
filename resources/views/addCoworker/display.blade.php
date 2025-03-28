@extends('layouts.app')

@section('content')
<div class="container">
    <h2>List of Coworkers</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="controls filter_containers  mb-3">
            <form id="branchFilterForm" action="{{ route('addCoworker.display') }}" method="GET" class="">
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
    <div class="table-responsive display_table_data">
       

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Info</th>
                    <th>Email</th>
                    <th>Branch Name</th>
                    <th>Seat Type</th>
                    <th>Private Office Size</th>
                    <th>Number of Seats</th>
                    <th>Joining Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($coworkers as $coworker)
                <tr>
                    <td>{{ $coworker->name }}</td>
                    <td>{{ $coworker->contact_info }}</td>
                    <td>{{ $coworker->email }}</td>
                    <td>{{ $coworker->branch->branch_name ?? 'N/A' }}</td>
                    <td>{{ $coworker->seat_type }}</td>
                    <td>{{ $coworker->private_office_size ?? 'N/A' }}</td>
                    <td>{{ $coworker->no_of_seats ?? 'N/A' }}</td>
                    <td>{{ $coworker->joining_date }}</td>
                    <td>
                        <div class='btn-group'>
                            <a class='btn btn-primary btn-sm' href="{{ route('coworkers.edit', $coworker->coworker_id) }}" role='button'>
                                <button>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </button>
                            </a>
                            <form action="{{ route('coworkers.destroy', $coworker->coworker_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class='btn btn-danger btn-sm' onclick="return confirm('Are you sure you want to delete this coworker?')">
                                    <i class='fa-solid fa-trash'></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">No coworkers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $coworkers->appends(['branch_id' => $branchId])->links('pagination::tailwind') }}
    </div>
</div>
@endsection