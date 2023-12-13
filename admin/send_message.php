<?php
include '../configurations.php';
include '../functions.php';
?>

<?php include '../navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery for live search -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add FontAwesome CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fffbf2;
            /* Pale yellow background */
        }

        .container {
            max-width: 1500px;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 20px;
        }

        .icon {
            font-size: 2em;
            /* Adjust the font size as needed */
            display: inline-block;
        }


        .btn-primary {
    background-color: #e07c00;
    /* Button background color */
    border-color: #e07c00;
    /* Button border color */
    width: 100%;
    /* Make button width 100% of the container */
}


        .btn-primary:hover {
            background-color: #cc6600;
            /* Button hover background color */
            border-color: #cc6600;
        }

        .success-message {
            color: #28a745;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .card {
            padding: 2%;
        }
    </style>

</head>

<!-- Inside the head section -->
<!-- Inside the head section -->
<script>
    function sendSMS(phoneNumber, amount) {
        var api_key = '6d77e575c33bf1c2';
        var secret_key = 'MGJmNjcwMzczMDFjNDY5ZDg2Yzc5YTcxZDVlOTEzYzY0MzI3YTI3MDZkZmQyMjI4ODJiZTNkMjY5ZWNhMzc1Yw==';

        // Include the amount in the message
        var message = 'Hello, we have received a contribution equals to Tsh' + amount;

        var postData = {
            'source_addr': 'INFO',
            'encoding': 0,
            'schedule_time': '',
            'message': message,
            'recipients': [{
                'recipient_id': '1',
                'dest_addr': phoneNumber
            }]
        };

        $.ajax({
            type: 'POST',
            url: 'https://apisms.beem.africa/v1/send',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', 'Basic ' + btoa(api_key + ':' + secret_key));
                xhr.setRequestHeader('Content-Type', 'application/json');
            },
            data: JSON.stringify(postData),
            success: function(response) {
                // Handle success response here
                console.log(response);
                alert('SMS sent successfully to ' + phoneNumber);

                // Check if the response indicates success, then update the flag to 1
                if (response.status === 'success') {
                    updateFlagInDatabase(phoneNumber, 1);
                } else {
                    // If the response is not success, update the flag to 2
                    updateFlagInDatabase(phoneNumber, 1);
                }
            },
            error: function(error) {
                // Handle error response here
                console.error(error);
                alert('Failed to send SMS to ' + phoneNumber);

                // If there's an error, update the flag to 2
                updateFlagInDatabase(phoneNumber, 2);
            }
        });
    }

    function updateFlagInDatabase(phoneNumber, flagValue) {
        // You need to implement the code to update the flag in the database.
        // You can use AJAX or another method to send an update request to the server.

        // Example AJAX request to update flag value (you may need to modify this based on your server-side code):
        $.ajax({
            type: 'POST',
            url: 'update_flag.php', // Replace with the actual URL for updating flag
            data: {
                phoneNumber: phoneNumber,
                flagValue: flagValue
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
</script>




<!-- view.php -->
<body>
<div class="container">
    <div class="card">
    <div class="row">
    <div class="col-md-12">
    <div class="icon" style="display: inline-block; margin-right: 10px;">
        <i class="fas fa-envelope"></i>
    </div>
    <h2 class="d-inline-block"> Send Message</h2>
</div>
        </div>

        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="startDate" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="endDate" class="form-label">End Date:</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="endDate" class="form-label"> &nbsp; </label>
                                <input type="button" class="form-control" style="background-color:#e07c00; color:white" id="filterBtn" value="Filter Products by Date">
                            </div>
                        </div>
        <div class="card-body">
            <?php
            // Retrieve members from the database based on search query
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $sql = "SELECT a.member_id, a.firstName, a.phoneNumber, t.recored_datetime, t.flag_value, j.name AS jumuiya_name, t.amount
            FROM all_members a
            JOIN tithe_collection t ON a.member_id = t.member_id
            JOIN jumuiya j ON a.jumuiya_name = j.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            ?>
                <table class="table table-bordered table-striped" id="tithetable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Jumuiya</th>
                            <th>Amount</th>
                            <th>Phone Number</th>
                            <th>Date Created</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['member_id'] . '</td>';
                            echo '<td>' . $row['firstName'] . '</td>';
                            echo '<td>' . $row['jumuiya_name'] . '</td>';
                            echo '<td>' . $row['amount'] . '</td>';
                            echo '<td>' . $row['phoneNumber'] . '</td>';
                            echo '<td>' . date('Y-m-d', strtotime($row['recored_datetime'])) . '</td>';
                            echo '<td><button class="btn btn-primary" onclick="sendSMS(\'' . $row['phoneNumber'] . '\', ' . $row['amount'] . ')">Send SMS</button></td>';
                            echo '<td class="text-center">';
                            if ($row['flag_value'] == 1) {
                                echo '<i class="fas fa-check"></i>';
                            } elseif ($row['flag_value'] == 2) {
                                echo '<i class="fas fa-clock"></i>';
                            } else {
                                echo '<i class="fas fa-times"></i>';
                            }
                            echo '</td>';

                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo '<p>No members found</p>';
            }
            ?>
        </div>
    </div>
</div>



</body>
<?php
// Close the database connection
$conn->close();
?>

<script>
document.getElementById('filterBtn').addEventListener('click', function () {
    var startDate = new Date(document.getElementById('startDate').value);
    var endDate = new Date(document.getElementById('endDate').value);

    var table = document.getElementById('tithetable');
    var rows = table.getElementsByTagName('tr');

    for (var i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
        var cell = rows[i].getElementsByTagName('td')[5]; // Assuming date is in the first column

        if (cell) {
            var cellDate = new Date(cell.textContent);

            if (cellDate >= startDate && cellDate <= endDate) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
});

$(document).ready(function () {
            $('#tithetable').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        });
</script>



