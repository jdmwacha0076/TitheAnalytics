<?php
include '../configurations.php';
include '../functions.php';
?>
<?php include 'navbar.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $jumuiya_name = $_POST['jumuiya_name'];

    $success = AddMembers($firstName, $lastName, $phoneNumber, $jumuiya_name);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="rowx">
                <div class="col-md-12">
                    <div class="register-icons" style="display: inline-block; margin-right: 20px;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="d-inline-block custom-heading">Sajili Mtoa Zaka Mpya</h2>
                </div>
            </div>

            <?php if (isset($success)) { ?>
                <?php if ($success) { ?>
                    <div class="alert alert-success" role="alert">
                        Member added successfully
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                        Error adding member
                    </div>
                <?php } ?>
            <?php } ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phoneNumber">Phone Number: </label>
                    <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" title="Enter a valid phone number (e.g., 0123456789)" oninput="transformPhoneNumber(this)" required>
                    <small class="form-text text-muted">Format: 0xxxxxxxxx</small>
                </div>

                <div class="form-group">
                    <label for="jumuiya">Jumuiya:</label>
                    <select id="jumuiya" name="jumuiya_name" class="form-control">
                        <?php
                        $sql = "SELECT id, name FROM jumuiya";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Member</button>
            </form>
        </div>
    </div>

</body>

<!--Script for formatting the phone number-->
<script>
    function transformPhoneNumber(input) {
        let cleanedInput = input.value.replace(/\D/g, '');
        cleanedInput = cleanedInput.substring(0, 12);
        if (cleanedInput.indexOf('0') === 0) {
            cleanedInput = '255' + cleanedInput.substring(1);
        }
        input.value = cleanedInput;
    }
</script>