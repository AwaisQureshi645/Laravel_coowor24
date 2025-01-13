@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Branches</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('branches.create') }}" class="btn btn-primary mb-3">Add New Branch</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Branch Name</th>
                <th>Location</th>
                <th>Contact Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $branch)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td>{{ $branch->location }}</td>
                    <td>{{ $branch->contact_details }}</td>
                    <td>
                                    <div class='icbtn'>
                                        <a class='btn btn-primary btn-sm' href='' role='button'>
                                            <i class='fa-solid fa-pen-to-square'></i>
                                        </a>
                                        <a class='btn btn-danger btn-sm' href='' role='button'>
                                            <i class='fa-solid fa-trash'></i>
                                        </a>
                                    </div>
                                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
