<?php
include '../configurations.php';
include '../functions.php';
?>
<?php include 'navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

    <!-- DataTables CSS -->
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
            max-width: 1600px;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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


        .register-icon {
            font-size: 1em;
            color: #333;
            margin-right: 10px;
            display: inline-block;
            font-weight: bold;
        }

        .card {
            padding: 2%;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            font-size: 1.2em;
            margin-bottom: 5px;
            display: block;
        }

        .form-group small {
            color: #888;
        }

        .custom-heading {
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
            padding-bottom: 1%;
            /* Add some margin for spacing */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="row search-box">
                <div class="col-md-8">
                    <h2><i class="fas fa-search register-icon"></i><span class="custom-heading">Registered Members</span></h2>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search">Search by ID:</label>
                        <input type="text" id="search" class="form-control" oninput="filterTable()" placeholder="Enter ID">
                    </div>
                </div>
            </div>

            <table id="memberTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Jumuiya Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT all_members.*, jumuiya.name AS jumuiya_name
                FROM all_members
                JOIN jumuiya ON all_members.jumuiya_name = jumuiya.id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['member_id'] . '</td>';
                            echo '<td>' . $row['firstName'] . '</td>';
                            echo '<td>' . $row['lastName'] . '</td>';
                            echo '<td>' . $row['phoneNumber'] . '</td>';
                            echo '<td>' . $row['jumuiya_name'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No members found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--Script to search member by ID -->
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("memberTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        $(document).ready(function() {
            $('#memberTable').DataTable({
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

</body>

</html>