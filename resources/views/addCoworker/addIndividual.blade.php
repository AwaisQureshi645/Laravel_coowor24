<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="form_container">
            <h3>Add Individual Coworker</h3>
            <form action="{{ route('coworkers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            
            <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="contact_info">Contact Info</label>
                <input type="text" id="contact_info" name="contact_info" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="branch_id">Select Branch</label>
                <select id="branch_id" name="branch_id" required>
                    <option value="1">Branch 1</option>
                </select>

                <label for="seat_type">Seat Type</label>
                <select id="seat_type" name="seat_type" onchange="toggleFields()" required>
                    <option value="">Select Seat Type</option>
                    <option value="dedicated_seat">Dedicated Seat</option>
                    <option value="private_office">Private Office</option>
                </select>

                <label for="private_office_size">Private Office Size</label>
                <select id="private_office_size" name="private_office_size" disabled>
                    <option value="">Select Private Office Size</option>
                    <option value="8_person">8 Person Office</option>
                    <option value="16_person">16 Person Office</option>
                    <option value="22_person">22 Person Office</option>
                    <option value="40_person">40 Person Office</option>
                </select>

                <label for="no_of_seats">Number of Seats</label>
                <input type="number" id="no_of_seats" name="no_of_seats" disabled>

                <label for="joining_date">Joining Date</label>
                <input type="date" id="joining_date" name="joining_date">

                <label for="contract_copy">Upload Contract (optional)</label>
                <input type="file" id="contract_copy" name="contract_copy">

                <button type="submit">Submit</button>
            </form>
        </div>
</body>
</html>