<?php
include '../configurations.php';
include '../functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted for recording tithe contribution
    if (isset($_POST['saveTitheContribution'])) {
        // Get the form data
        $memberId = $_POST['selectedMemberId'];
        $amount = $_POST['amount'];

        // Validate and sanitize the input (you should add more robust validation)
        $memberId = filter_var($memberId, FILTER_VALIDATE_INT);
        $amount = filter_var($amount, FILTER_VALIDATE_INT);

        if ($memberId !== false && $amount !== false) {
            // Insert the tithe contribution into the database
            $sql = "INSERT INTO tithe_collection (member_id, recored_datetime, amount) VALUES ('$memberId', NOW(), '$amount')";

            if ($conn->query($sql) === TRUE) {
                // Tithe contribution successfully recorded
                $successMessage = "Tithe contribution recorded successfully.";
            } else {
                // Error recording tithe contribution
                $errorMessage = "Error recording tithe contribution: " . $conn->error;
            }
        } else {
            // Invalid input
            $errorMessage = "Invalid input. Please enter a valid member ID and amount.";
        }
    }
}

// Fetch and display members
$sql = "SELECT all_members.*, jumuiya.name AS jumuiya_name
        FROM all_members
        JOIN jumuiya ON all_members.jumuiya_name = jumuiya.id";
$result = $conn->query($sql);
?>

<?php include '../navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your meta tags, CSS, and JS links here -->

    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("memberTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; tr.length; i++) {
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

        function showTitheContributionForm(memberId) {
            var titheContributionForm = document.getElementById("titheContributionForm");
            titheContributionForm.style.display = "block";
            document.getElementById("selectedMemberId").value = memberId;
        }

        function hideTitheContributionForm() {
            var titheContributionForm = document.getElementById("titheContributionForm");
            titheContributionForm.style.display = "none";
        }
    </script>

    <style>
        /* Add your styles here */
        .success-message {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

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
        .card {
            padding: 2%;
        }
    </style>
</head>

<body>
    <div class="container">
    <div class="card">
        <div class="row search-box">
            <div class="col-md-12">
                <h2><i class="fas fa-search register-icon"></i> &emsp; Search and Record Tithe Contribution</h2>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr style="display:none;">';
                        echo '<td>' . $row['member_id'] . '</td>';
                        echo '<td>' . $row['firstName'] . '</td>';
                        echo '<td>' . $row['lastName'] . '</td>';
                        echo '<td>' . $row['phoneNumber'] . '</td>';
                        echo '<td>' . $row['jumuiya_name'] . '</td>';
                        echo '<td><button class="btn btn-success" onclick="showTitheContributionForm(' . $row['member_id'] . ')"><i class="fas fa-coins"></i> Record Tithe</button></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No members found</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Tithe Contribution Form Popup -->
        <div id="titheContributionForm" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border-radius: 5px;">
                <h3>Record Tithe Contribution</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" id="selectedMemberId" name="selectedMemberId" value="">
                    <label for="amount">Amount:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="amount-addon">$</span>
                        </div>
                        <input type="text" id="amount" name="amount" class="form-control" required>
                    </div>
                    <br>
                    <button type="button" class="btn btn-secondary" onclick="hideTitheContributionForm()"><i class="fas fa-times"></i> Cancel</button>
                    <button type="submit" name="saveTitheContribution" class="btn btn-primary"><i class="fas fa-save"></i> Save Tithe Contribution</button>
                </form>
            </div>
        </div>

        <?php
        // Display success or error messages
        if (isset($successMessage)) {
            echo '<div class="alert alert-success success-message">' . $successMessage . '</div>';
        }

        if (isset($errorMessage)) {
            echo '<div class="alert alert-danger error-message">' . $errorMessage . '</div>';
        }
        ?>

    </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

