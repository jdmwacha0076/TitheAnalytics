<?php
include '../configurations.php';
include '../functions.php';
?>
<?php include '../navbar.php'; ?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $jumuiya_name = $_POST['jumuiya_name'];

    // Insert the values into the database using the function
    $success = AddMembers($firstName, $lastName, $phoneNumber, $jumuiya_name);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add FontAwesome CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .form-group {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #e07c00;
            /* Button background color */
            border-color: #e07c00;
            /* Button border color */
            padding: 12px;
            /* Increase button padding */
            border-radius: 5px;
            /* Button border radius */
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

<body>

    <div class="container">
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="icon" style="display: inline-block; margin-right: 10px;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="d-inline-block">Add Member</h2>
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

<script>
    function transformPhoneNumber(input) {
        // Remove non-digit characters
        let cleanedInput = input.value.replace(/\D/g, '');

        // Ensure the input is limited to 10 digits
        cleanedInput = cleanedInput.substring(0, 12);

        // If the cleaned input starts with '0', replace it with '255'
        if (cleanedInput.indexOf('0') === 0) {
            cleanedInput = '255' + cleanedInput.substring(1);
        }

        // Update the input value
        input.value = cleanedInput;
    }
</script>







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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>


