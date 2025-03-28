@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Team Bookings</h1>

    <!-- Success and Error Messages -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <!-- display the branch filter -->
    <div class="controls filter_containers  mb-3">
        <form id="branchFilterForm" action="{{ route('teamBookings.index') }}" method="GET" class="">
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
    <!-- Display Table -->
    <div class=" display_table_data">

        <table class="table table-bordered display_table_data">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Team Name</th>
                    <th>Joining Date</th>
                    <th>Ending Date</th>
                    <th>Security Amount</th>
                    <th>Point of Contact</th>
                    <th>Number of Members</th>
                    <th>Branch</th>
                    <th>Reference</th>
                    <th>Contract Copy</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teamBookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->team_name }}</td>
                    <td>{{ $booking->joining_date }}</td>
                    <td>{{ $booking->ending_date }}</td>
                    <td>{{ $booking->security_amount }}</td>
                    <td>{{ $booking->point_of_contact }}</td>
                    <td>{{ $booking->num_members }}</td>
                    <td>{{ $booking->branch->branch_name ?? 'N/A' }}</td>
                    <td>{{ $booking->reference ?? 'N/A' }}</td>
                    <td>
                        @if ($booking->contract_copy)
                        <a href="{{ asset('storage/' . $booking->contract_copy) }}" target="_blank">View</a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        <div class='btn-group'>
                            <a href="{{ route('teamBookings.edit', $booking->id) }}" class="btn btn-warning">
                                <button> <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>
                            <form action="{{ route('teamBookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"> <i class='fa-solid fa-trash'></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">No team bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection