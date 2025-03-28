@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New User</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Display Error Message -->
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="{{ route('coworkerusers.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber">Phone Number</label>
            <input type="text" name="phonenumber" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" required>
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
            <input type="text" name="cnic" class="form-control" value="{{ old('cnic') }}" required>
        </div>

        <div class="mb-3">
            <label for="image">Upload CNIC Image</label>
            <input type="file" name="cnic_pic" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection