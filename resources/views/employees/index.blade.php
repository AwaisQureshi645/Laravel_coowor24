@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Employees</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Branch</th>
                <th>Role</th>
                <th>CNIC</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->username }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phonenumber }}</td>
                    <td>{{ $employee->branch->branch_name ?? 'N/A' }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>{{ $employee->cnic }}</td>
                    <td>{{ $employee->address }}</td>
                    <td>
                    <a href="{{ route('employees.edit', $employee->coworker_employees_id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('employees.destroy', $employee->coworker_employees_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
