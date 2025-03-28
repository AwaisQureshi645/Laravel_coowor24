@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Employee</h2>
    <form action="{{ route('employees.update', $employee->coworker_employees_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $employee->username }}" required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber">Phone Number</label>
            <input type="text" name="phonenumber" class="form-control" value="{{ $employee->phonenumber }}" required>
        </div>
        <div class="mb-3">
            <label for="branch_id">Branch</label>
            <select name="branch_id" class="form-control" required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->branch_id }}" {{ $branch->branch_id == $employee->branch_id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="role">Role</label>
            <input type="text" name="role" class="form-control" value="{{ $employee->role }}" required>
        </div>
        <div class="mb-3">
            <label for="cnic">CNIC</label>
            <input type="text" name="cnic" class="form-control" value="{{ $employee->cnic }}" required>
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $employee->address }}" required>
        </div>
        <div class="mb-3">
            <label for="cnic_pic">Upload CNIC Picture (Optional)</label>
            <input type="file" name="cnic_pic" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
