<?php
include '../configurations.php';
include '../functions.php';
?>

<?php include 'navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

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
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8d400;
            /* Yellow header background */
            color: #333;
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

        .custom-label {
            font-weight: bold;
            margin-bottom: 5px;
            /* Add some margin for spacing */
            display: block;
        }

        .custom-heading {
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
            padding-bottom: 1%;
            /* Add some margin for spacing */
        }

        .filter-control {
            background-color: #e07c00;
            /* Set the button background color to yellow */
            color: #ffffff;
            /* Set the text color to black or your preferred color */
            transition: background-color 0.3s ease;
            /* Add a transition effect for fading */
            border: none;
            /* Remove button border for a cleaner look */
            padding: 5px 10px;
            width: 100%;
            /* Adjust padding as needed */
        }

        .filter-control {
            background-color: #e07c00;
            /* Set the button background color to a faded yellow on hover */
        }
    </style>

</head>

<script>
    function sendSMS(phoneNumber, amount) {
        var api_key = '6d77e575c33bf1c2';
        var secret_key = 'MGJmNjcwMzczMDFjNDY5ZDg2Yzc5YTcxZDVlOTEzYzY0MzI3YTI3MDZkZmQyMjI4ODJiZTNkMjY5ZWNhMzc1Yw==';
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
                console.log(response);
                alert('SMS sent successfully to ' + phoneNumber);
                if (response.status === 'success') {
                    updateFlagInDatabase(phoneNumber, 1);
                } else {
                    updateFlagInDatabase(phoneNumber, 1);
                }
            },
            error: function(error) {
                console.error(error);
                alert('Failed to send SMS to ' + phoneNumber);
                updateFlagInDatabase(phoneNumber, 2);
            }
        });
    }

    function updateFlagInDatabase(phoneNumber, flagValue) {
        $.ajax({
            type: 'POST',
            url: 'update_flag.php',
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

<body>
    <div class="container">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="icon" style="display: inline-block; margin-right: 10px;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h2 class="d-inline-block custom-heading"> Send Message</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-4">
                    <label for="startDate" class="form-label custom-label">Start Date:</label>
                    <input type="date" class="form-control" id="startDate">
                </div>
                <div class="col-md-5 mb-4">
                    <label for="endDate" class="form-label custom-label">End Date:</label>
                    <input type="date" class="form-control" id="endDate">
                </div>
                <div class="col-md-2 mb-4">
                    <label for="endDate" class="form-label"> &nbsp; </label>
                    <input type="button" class="form-control" style="background-color:#e07c00; color:white" id="filterBtn" value="Filter">
                </div>
            </div>

            <div class="card-body">
                <?php
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
                                echo '<td><button class="filter-control" onclick="sendSMS(\'' . $row['phoneNumber'] . '\', ' . $row['amount'] . ')">Send SMS</button></td>';
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
$conn->close();
?>

<!--Script to search and pagination of the table -->
<script>
    document.getElementById('filterBtn').addEventListener('click', function() {
        var startDate = new Date(document.getElementById('startDate').value);
        var endDate = new Date(document.getElementById('endDate').value);

        var table = document.getElementById('tithetable');
        var rows = table.getElementsByTagName('tr');

        for (var i = 1; i < rows.length; i++) {
            var cell = rows[i].getElementsByTagName('td')[5];

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

    $(document).ready(function() {
        $('#tithetable').DataTable({
            'dom': 'lfrtip',
            'paging': true,
            'lengthChange': true,
            'searching': false,
            'ordering': false,
            'info': true,
            'autoWidth': false
        });
    });
</script>