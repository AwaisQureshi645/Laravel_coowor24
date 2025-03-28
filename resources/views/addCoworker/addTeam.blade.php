<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Team Details</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
       

       
    </style>
</head>
<body>
    <div class="form_container">
        <h1>Enter Team Details</h1>
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="team_name">Team Name:</label>
                <input type="text" id="team_name" name="team_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="joining_date">Joining Date:</label>
                <input type="date" id="joining_date" name="joining_date" class="form-control" required onclick=this.showPicker()>
            </div>

            <div class="form-group">
                <label for="ending_date">Ending Date:</label>
                <input type="date" id="ending_date" name="ending_date" class="form-control" required onclick=this.showPicker()>
            </div>

            <div class="form-group">
                <label for="security_amount">Security Amount:</label>
                <input type="number" id="security_amount" name="security_amount" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="point_of_contact">Point of Contact:</label>
                <textarea id="point_of_contact" name="point_of_contact" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="num_members">Number of Members:</label>
                <input type="number" id="num_members" name="num_members" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="branch_id">Select Branch:</label>
                <select id="branch_id" name="branch_id" class="form-control" required>
                    <option value="1">Branch 1</option>
                    <option value="2">Branch 2</option>
                </select>
            </div> 

            <div class="form-group">
                <label for="reference">Reference:</label>
                <input type="text" id="reference" name="reference" class="form-control">
            </div>

            <div class="form-group">
                <label for="contract_copy">Contract Copy (optional):</label>
                <input type="file" id="contract_copy" name="contract_copy" class="form-control" accept=".jpg,.jpeg,.png,.webp,.pdf">
            </div>

            <button type="submit">Submit Booking</button>
        </form>
    </div>

    <script>
        <?php if (isset($_GET['success'])): ?>
            alert('Team details added successfully!');
        <?php elseif (isset($_GET['error'])): ?>
            alert('An error occurred. Please try again.');
        <?php endif; ?>
    </script>
</body>
</html>
