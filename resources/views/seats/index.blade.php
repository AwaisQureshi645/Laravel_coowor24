<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Seating Management</title>
    <style>
        .d-flex {
            display: flex;
        }

        .flex-row {
            flex-direction: row;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .justify-content-start {
            justify-content: flex-start;
        }

        .seat {
            width: 70px;
            height: 70px;
            margin: 5px;
            border: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .seat:hover {
            transform: scale(1.05);
            border-color: var(--primary-color);
        }

        .available {
            background-color: #28a745;
            color: white;
        }

        .occupied {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1 class="text-center">Office Seating Management</h1>
        <label for="branchSelect" class="mr-2">Select Branch:</label>
        <div class="controls d-flex justify-content-center align-items-center">
            <select id="branchSelect" class="form-control w-25">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
            <button id="addSeatBtn" class="btn btn-warning ml-3">Add New Seat</button>
        </div>
        <div id="seatingCharts" class="mt-4"></div>
    </div>

    <!-- Modal for Adding a New Seat -->
    <div id="addSeatModal" class="modal">
        <div class="modal-content">
            <span id="closeAddSeatModal" class="close">&times;</span>
            <h2>Add New Seats</h2>
            <form id="addSeatForm">
                <label for="seatCount">Number of Seats:</label>
                <input type="number" id="seatCount" name="seat_count" class="form-control" required>

                <label for="branchSelectAdd">Select Branch:</label>
                <select id="branchSelectAdd" name="branch_id" class="form-control" required>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                    @endforeach
                </select>

                <label for="assignCoworkerName">Assign Coworker Name (Optional):</label>
                <input type="text" id="assignCoworkerName" name="assign_coworker_name" class="form-control">

                <button type="submit" class="btn btn-primary mt-3">Add Seats</button>
            </form>
        </div>
    </div>

    <script>
        const addSeatModal = document.getElementById('addSeatModal');
        const addSeatBtn = document.getElementById('addSeatBtn');
        const closeAddSeatModal = document.getElementById('closeAddSeatModal');
        const addSeatForm = document.getElementById('addSeatForm');
        const branchSelect = document.getElementById('branchSelect');
        const seatingCharts = document.getElementById('seatingCharts');

        addSeatBtn.addEventListener('click', () => {
            addSeatModal.style.display = 'block';
        });

        closeAddSeatModal.addEventListener('click', () => {
            addSeatModal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === addSeatModal) {
                addSeatModal.style.display = 'none';
            }
        });

        function fetchSeats() {
            const branchId = branchSelect.value;
            fetch(`/seats/fetch?branch_id=${branchId}`)
                .then((response) => response.json())
                .then((seats) => {
                    seatingCharts.innerHTML = '';
                    if (seats.length === 0) {
                        seatingCharts.innerHTML = '<p class="text-center">No seats available for this branch.</p>';
                        return;
                    }

                    const branchName = seats[0]?.branch?.branch_name || 'Branch';
                    const branchTitle = document.createElement('h3');
                    branchTitle.classList.add('text-center', 'text-primary');
                    branchTitle.textContent = `${branchName} - Total Seats: ${seats.length}`;
                    seatingCharts.appendChild(branchTitle);

                    const seatContainer = document.createElement('div');
                    seatContainer.className = 'd-flex flex-row flex-wrap justify-content-start';

                    seats.forEach((seat) => {
                        const seatDiv = document.createElement('div');
                        seatDiv.className = `seat available`;
                        seatDiv.textContent = seat.seat_number;

                        seatContainer.appendChild(seatDiv);
                    });

                    seatingCharts.appendChild(seatContainer);
                })
                .catch((error) => console.error('Error fetching seats:', error));
        }

        addSeatForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const seatCount = document.getElementById('seatCount').value;
            const branchId = document.getElementById('branchSelectAdd').value;
            const assignCoworkerName = document.getElementById('assignCoworkerName').value;

            fetch('/seats/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    seat_count: seatCount,
                    branch_id: branchId,
                    assign_coworker_name: assignCoworkerName,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Seats added successfully!');
                        addSeatModal.style.display = 'none';
                        fetchSeats();
                    } else {
                        alert('Failed to add seats.');
                    }
                })
                .catch((error) => console.error('Error adding seats:', error));
        });

        branchSelect.addEventListener('change', fetchSeats);

        document.addEventListener('DOMContentLoaded', fetchSeats);
    </script>
    @endsection
</body>
</html>
