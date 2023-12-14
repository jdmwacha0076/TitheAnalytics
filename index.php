<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="./assets/logo2.png" rel="icon">
    <link rel="stylesheet" href="./assets/loginstyles.css">
</head>

<body>
    <div class="container">
        <div class="icon">
            <i class="fas fa-church"></i>
        </div>
        <h2 class="text-center mb-4">Welcome Back</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $servername = "localhost";
            $username = "root";
            $db_password = "";
            $dbname = "parokiayamwenge";

            $conn = new mysqli($servername, $username, $db_password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM admin WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $hashed_password = $row["password"];

                    if (password_verify($password, $hashed_password)) {
                        header('Location: admin/home.php');
                        exit;
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Incorrect email or password. Please try again.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Incorrect email or password. Please try again.</div>';
                }
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="text-center mt-4">
                <a href="signup.php" class="signup-link">Create Account</a> | <a href="#" class="signup-link">Forgot Password</a>
            </p>
        </form>
    </div>

</body>

</html>