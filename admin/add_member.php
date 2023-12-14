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
            margin-top: 15px;
        }

        .icon {
            font-size: 2em;
            /* Adjust the font size as needed */

            font-weight: bold;
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
            margin-top: 15px;
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
            <div class="rowx">
                <div class="col-md-12">
                    <div class="icon" style="display: inline-block; margin-right: 20px;">
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