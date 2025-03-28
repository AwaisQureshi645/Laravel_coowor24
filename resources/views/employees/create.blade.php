@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Employee</h2>
    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
       
        <div class="mb-3">
            <label for="phonenumber">Phone Number</label>
            <input type="text" name="phonenumber" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="branch_id">Branch</label>
            <select name="branch_id" class="form-control" required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="role">Role</label>
            <input type="text" name="role" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cnic">CNIC</label>
            <input type="text" name="cnic" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cnic_pic">Upload CNIC Picture (Optional)</label>
            <input type="file" name="cnic_pic" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
