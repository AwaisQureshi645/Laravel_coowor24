@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Offices</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('offices.create') }}" class="btn btn-primary mb-3">Add New Office</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Room No</th>
                <th>Capacity</th>
                <th>Price</th>
                <th>Branch</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offices as $office)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $office->RoomNo }}</td>
                <td>{{ $office->capacity }}</td>
                <td>{{ $office->Price }}</td>
                <td>{{ $office->branch->branch_name ?? 'N/A' }}</td>
                <td>{{ $office->status }}</td>
                <td class="d-flex flex-row">
                    <a href="{{ route('offices.edit', $office->id) }}" class="btn btn-primary"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('offices.destroy', $office->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection