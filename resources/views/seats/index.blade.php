@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Office Seating Management</h1>

    <label for="branchSelect">Select Branch:</label>
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

<!-- Modal for Adding New Seat -->
<div id="addSeatModal" class="modal" style="display: none;">
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

            <button type="submit" class="btn btn-primary mt-3">Add Seats</button>
        </form>
    </div>
</div>

<!-- Modal for Assigning Coworker -->
<div id="assignCoworkerModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span id="closeAssignCoworkerModal" class="close">&times;</span>
        <h2>Assign Coworker</h2>
        <form id="assignCoworkerForm">
            <input type="hidden" id="seatId" name="seat_id">
            <label for="coworkerSelect">Select Coworker:</label>
            <select id="coworkerSelect" name="coworker_id" class="form-control" required>
                <!-- Options will be populated dynamically -->
            </select>
            <button type="submit" class="btn btn-primary mt-3">Assign Coworker</button>
        </form>
    </div>
</div>

<style>
.seat {
    width: 100px;
    height: 100px;
    margin: 10px;
    border: 1px solid #ccc;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    cursor: pointer;
    background-color: #f8f9fa;
}

.seat.available {
    background-color: #65a875;
}

.seat.occupied {
    background-color: #79363c;
}

.delete-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    border: none;
    background: none;
    color: red;
    font-size: 20px;
    cursor: pointer;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: none;
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    width: 50%;
    position: relative;
}

.close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 24px;
    cursor: pointer;
}

.coworker-name {
    font-size: 12px;
    margin-top: 5px;
    text-align: center;
}
.d-flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px; /* Add spacing between cards */
    }
</style>

<script>
    const branchSelect = document.getElementById('branchSelect');
    const seatingCharts = document.getElementById('seatingCharts');
    const addSeatModal = document.getElementById('addSeatModal');
    const addSeatBtn = document.getElementById('addSeatBtn');
    const closeAddSeatModal = document.getElementById('closeAddSeatModal');
    const addSeatForm = document.getElementById('addSeatForm');

    const assignCoworkerModal = document.getElementById('assignCoworkerModal');
    const closeAssignCoworkerModal = document.getElementById('closeAssignCoworkerModal');
    const assignCoworkerForm = document.getElementById('assignCoworkerForm');
    const coworkerSelect = document.getElementById('coworkerSelect');

    let selectedSeatId = null;

    // Open Add Seat Modal
    addSeatBtn.addEventListener('click', () => {
        addSeatModal.style.display = 'block';
    });

    // Close Add Seat Modal
    closeAddSeatModal.addEventListener('click', () => {
        addSeatModal.style.display = 'none';
    });

    // Open Assign Coworker Modal
    function openAssignCoworkerModal(seatId) {
        selectedSeatId = seatId;
        document.getElementById('seatId').value = seatId;
        assignCoworkerModal.style.display = 'block';
        fetchCoworkers();
    }

    // Close Assign Coworker Modal
    closeAssignCoworkerModal.addEventListener('click', () => {
        assignCoworkerModal.style.display = 'none';
    });

    // Fetch Seats
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

                const seatContainer = document.createElement('div');
                seatContainer.className = 'd-flex flex-wrap justify-content-start';

                seats.forEach((seat) => {
                    const seatDiv = document.createElement('div');
                    seatDiv.className = `seat ${seat.status}`;
                    
                    // Add seat number
                    const seatNumber = document.createElement('div');
                    seatNumber.textContent = seat.seat_id;
                    seatDiv.appendChild(seatNumber);
                    
                    // Add coworker name if assigned
                    if (seat.coworker) {
                        const coworkerName = document.createElement('div');
                        coworkerName.className = 'coworker-name';
                        coworkerName.textContent = seat.coworker.name;
                        seatDiv.appendChild(coworkerName);
                    }
                    
                    seatDiv.setAttribute('data-seat-id', seat.seat_id);

                    // Add click event to open modal
                    seatDiv.addEventListener('click', () => {
                        if (seat.status !== 'occupied') {
                            openAssignCoworkerModal(seat.seat_id);
                        }
                    });

                    // Add delete button
                    const deleteBtn = document.createElement('button');
                    deleteBtn.textContent = '×';
                    deleteBtn.className = 'delete-btn';
                    deleteBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        deleteSeat(seat.seat_id);
                    });

                    seatDiv.appendChild(deleteBtn);
                    seatContainer.appendChild(seatDiv);
                });

                seatingCharts.appendChild(seatContainer);
            })
            .catch((error) => console.error('Error fetching seats:', error));
    }

    // Fetch Coworkers
    function fetchCoworkers() {
        fetch('/seats/coworkers')
            .then((response) => response.json())
            .then((coworkers) => {
                coworkerSelect.innerHTML = '<option value="">Select a coworker</option>';
                coworkers.forEach((coworker) => {
                    const option = document.createElement('option');
                    option.value = coworker.coworker_id;
                    option.textContent = coworker.name;
                    coworkerSelect.appendChild(option);
                });
            });
    }

    // Add New Seats
    addSeatForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(addSeatForm);

        fetch('/seats/add', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert('Seats added successfully!');
                    addSeatModal.style.display = 'none';
                    addSeatForm.reset();
                    fetchSeats();
                } else {
                    alert(data.message || 'Failed to add seats.');
                }
            })
            .catch((error) => console.error('Error adding seats:', error));
    });

    // Assign Coworker
    assignCoworkerForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(assignCoworkerForm);

        fetch('/seats/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert('Coworker assigned successfully!');
                    assignCoworkerModal.style.display = 'none';
                    assignCoworkerForm.reset();
                    fetchSeats();
                } else {
                    alert(data.message || 'Failed to assign coworker.');
                }
            })
            .catch((error) => console.error('Error assigning coworker:', error));
    });

    // Delete Seat
    function deleteSeat(seatId) {
        if (confirm('Are you sure you want to delete this seat?')) {
            fetch(`/seats/delete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ seat_id: seatId }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Seat deleted successfully!');
                        fetchSeats();
                    } else {
                        alert(data.message || 'Failed to delete seat.');
                    }
                })
                .catch((error) => console.error('Error deleting seat:', error));
        }
    }

    // Load seats on branch selection change
    branchSelect.addEventListener('change', fetchSeats);

    // Load seats on page load
    document.addEventListener('DOMContentLoaded', fetchSeats);

    // Close modals when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === addSeatModal) {
            addSeatModal.style.display = 'none';
        }
        if (e.target === assignCoworkerModal) {
            assignCoworkerModal.style.display = 'none';
        }
    });
</script>
@endsection