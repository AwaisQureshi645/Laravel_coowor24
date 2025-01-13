@extends('layouts.app')

@section('content')
<div class="container">
    <h2>List of Coworkers</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($coworkers->isEmpty())
        <p>No coworkers found.</p>
    @else
        <div class="table-responsive">
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
                    @foreach ($coworkers as $coworker)
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
                            <div class='icbtn'>
                                <a class='btn btn-primary btn-sm' href="{{ route('coworkers.edit', $coworker->id) }}" role='button'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>
                                <form action="{{ route('coworkers.destroy', $coworker->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class='btn btn-danger btn-sm' onclick="return confirm('Are you sure you want to delete this coworker?')">
                                        <i class='fa-solid fa-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
