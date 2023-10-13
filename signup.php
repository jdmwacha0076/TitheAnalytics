<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Create an Account</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"]; // Plain text password

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $db_password = ""; // Change this to your database password
            $dbname = "database";

            $conn = new mysqli($servername, $username, $db_password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $hashed_password);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Your account has been created successfully.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>
        <p class="text-center mt-3">
            <a href="index.php">Log In</a> | <a href="forgot_password.php">Forgot Password</a>
        </p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
