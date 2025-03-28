@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    <!-- Display success message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Display error messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coworkusers.update', $user->coworker_users_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber">Phone Number</label>
            <input type="text" name="phonenumber" value="{{ old('phonenumber', $user->phonenumber) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="branch_id">Branch</label>
            <select name="branch_id" class="form-control" required>
                @foreach ($branches as $branch)
                <option value="{{ $branch->branch_id }}" {{ $user->branch_id == $branch->branch_id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="role">Role</label>
            <input type="text" name="role" value="{{ old('role', $user->role) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cnic">CNIC</label>
            <input type="text" name="cnic" value="{{ old('cnic', $user->CNIC) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="image">Upload CNIC Image</label>
            <input type="file" name="cnic_pic" class="form-control">
            @if ($user->cnic_pic)
            <img src="{{ asset('storage/' . $user->cnic_pic) }}" alt="cnic_pic" class="mt-2" style="max-width: 100px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection