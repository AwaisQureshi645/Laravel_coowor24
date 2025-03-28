@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Branches</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<div class="button_contoll_width">
<a href="{{ route('branches.create') }}" class="btn btn-primary mb-3">
<button>
Add New Branch
</button>    
</a>

</div>

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
                    <div class='btn-group'>
                       
                            <a class='btn btn-danger btn-sm' href="{{ route('branches.edit', $branch->branch_id) }}" role='button'>
                            <button>
                            <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                          
                            </a>
                      

                        <form action="{{ route('branches.destroy', $branch->branch_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="" onclick="return confirm('Are you sure you want to delete this branch?')">
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $branches->links() }}
    </div>
</div>
@endsection