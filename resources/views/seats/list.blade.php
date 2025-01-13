@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Seat Management</h1>

    @foreach($branches as $branch)
        <div class="branch-block mt-4">
            <h3 class="branch-title">{{ $branch->branch_name }}</h3>
            <div class="seating-chart">
                @foreach($seats->where('branch_id', $branch->branch_id) as $seat)
                    <div class="seat {{ $seat->status }}">
                        Seat {{ $seat->seat_number }}
                        <br>
                        @if($seat->assign_coworker_name)
                            <small>{{ $seat->assign_coworker_name }}</small>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<style>
    .branch-block {
        margin: 20px auto;
        padding: 10px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .branch-title {
        text-align: center;
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 10px;
    }

    .seating-chart {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .seat {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: bold;
        color: white;
        text-align: center;
    }

    .seat.available {
        background-color: #28a745; /* Green */
    }

    .seat.occupied {
        background-color: #dc3545; /* Red */
    }
</style>
@endsection
