<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Coworker</title>
   
       
</head>

<body>
    <div class="container">
        <h2>Add Coworker</h2>

        <!-- Selection Form -->
        <form id="selectForm" class="form-section">
            <label for="coworker_type">Are you adding an individual or a team?</label>
            <select id="coworker_type" name="coworker_type" onchange="toggleForm()" required>
                <option value="">Choose an option</option>
                <option value="individual">Individual</option>
                <option value="team">Team</option>
            </select>
        </form>

        

    </div>

    <div id="individualForm" class="hidden">

        @include('addCoworker.addIndividual')
    </div>


    <!-- Redirect to Team Form -->
    <div id="teamForm" class="hidden">

       

    </div>


    <script>
        function toggleForm() {
            const coworkerType = document.getElementById("coworker_type").value;
            const individualForm = document.getElementById("individualForm");
            const teamForm = document.getElementById("teamForm");

            if (coworkerType === "individual") {
                individualForm.classList.remove("hidden");
                teamForm.classList.add("hidden");
            } else if (coworkerType === "team") {
                individualForm.classList.add("hidden");
                teamForm.classList.remove("hidden");
            } else {
                individualForm.classList.add("hidden");
                teamForm.classList.add("hidden");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const seatTypeSelect = document.getElementById('seat_type');
            const privateOfficeSizeSelect = document.getElementById('private_office_size');
            const noOfSeatsInput = document.getElementById('no_of_seats');

            function toggleFields() {
                if (seatTypeSelect.value === 'dedicated_seat') {
                    privateOfficeSizeSelect.disabled = true;
                    noOfSeatsInput.disabled = false;
                } else if (seatTypeSelect.value === 'private_office') {
                    privateOfficeSizeSelect.disabled = false;
                    noOfSeatsInput.disabled = true;
                } else {
                    privateOfficeSizeSelect.disabled = true;
                    noOfSeatsInput.disabled = true;
                }
            }

            seatTypeSelect.addEventListener('change', toggleFields);
        });
    </script>
</body>

</html>