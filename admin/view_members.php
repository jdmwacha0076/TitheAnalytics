<?php
include '../configurations.php';
include '../functions.php';
?>
<?php include 'navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="row search-box">
                <div class="col-md-8">
                    <h2><i class="fas fa-search register-icon"></i><span class="custom-heading">Watoa Zaka Walio Sajiliwa</span></h2>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search">Tafuta kwa Namba ya Kadi:</label>
                        <input type="text" id="search" class="form-control" oninput="filterTable()" placeholder="Andika Namba ya Kadi Hapa">
                    </div>
                </div>
            </div>

            <table id="memberTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No:</th>
                        <th>Jina la Kwanza</th>
                        <th>Jina la Mwisho</th>
                        <th>Nambari ya Simu</th>
                        <th>Jina la Jumuiya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT all_members.*, jumuiya.name AS jumuiya_name
                FROM all_members
                JOIN jumuiya ON all_members.jumuiya_name = jumuiya.id order by member_id desc";
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
                'autoWidth': false,
                'pageLength': 20,
                'lengthMenu': [20, 50, 100]
            });
        });
    </script>
    <?php include '../footer.php'; ?>
</body>

</html>