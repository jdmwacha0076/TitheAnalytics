<?php
include '../configurations.php';
include '../functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['saveTitheContribution'])) {
        $memberId = $_POST['selectedMemberId'];
        $amount = $_POST['amount'];
        $memberId = filter_var($memberId, FILTER_VALIDATE_INT);
        $amount = filter_var($amount, FILTER_VALIDATE_INT);

        if ($memberId !== false && $amount !== false) {
            $sql = "INSERT INTO tithe_collection (member_id, recored_datetime, amount) VALUES ('$memberId', NOW(), '$amount')";

            if ($conn->query($sql) === TRUE) {
                $successMessage = "Tithe contribution recorded successfully.";
            } else {
                $errorMessage = "Error recording tithe contribution: " . $conn->error;
            }
        } else {
            $errorMessage = "Invalid input. Please enter a valid member ID and amount.";
        }
    }
}

$sql = "SELECT all_members.*, jumuiya.name AS jumuiya_name
        FROM all_members
        JOIN jumuiya ON all_members.jumuiya_name = jumuiya.id";
$result = $conn->query($sql);
?>

<?php include 'navbar.php'; ?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body class="body2">
    <div class="container">
        <div class="card">
            <div class="row search-box">
                <div class="col-md-12">
                    <h2><i class="fas fa-search register-icon"></i><span class="custom-heading">Tafuta na Rekodi Zaka</span></h2>
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
                        <th>Chagua</th>
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
                            echo '<td><button class="btn btn-success" onclick="showTitheContributionForm(' . $row['member_id'] . ')"><i class="fas fa-coins"></i> Rekodi Taarifa</button></td>';
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
                    <h3>Rekodi Taarifa za Zaka</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="hidden" id="selectedMemberId" name="selectedMemberId" value="">
                        <label for="amount">Kiasi:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="amount-addon">Tsh</span>
                            </div>
                            <input type="text" id="amount" name="amount" class="form-control" required>
                        </div>
                        <br>
                        <button type="button" class="btn btn-secondary" onclick="hideTitheContributionForm()"><i class="fas fa-times"></i> Ghairi</button>
                        <button type="submit" name="saveTitheContribution" class="btn btns-primary"><i class="fas fa-save"></i> Kamilisha Rekodi ya Taarifa</button>
                    </form>
                </div>
            </div>

            <?php
            if (isset($successMessage)) {
                echo '<div class="alert alert-success success-message">' . $successMessage . '</div>';
            }

            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger error-message">' . $errorMessage . '</div>';
            }
            ?>

        </div>
    </div>
    <?php include '../footer.php'; ?>

</body>

<!--Script to show the form to enter amount -->
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