<?php
include_once 'config.php';
include_once 'Validation.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Check if fields are not empty
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($password)) {
        // Sanitize inputs
        $validation = new Validation();
        $name = $validation->clean($name);
        $email = $validation->clean($email);
        $phone = $validation->clean($phone);
        $password = $validation->clean($password);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: signup.php?error=Invalid email format");
            exit;
        }

        try {
            // Check if user exists by email
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                // Insert user into database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql1 = "INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)";
                $stmt = $pdo->prepare($sql1);
                $stmt->bindParam(':username', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $hashed_password);

                if ($stmt->execute()) {
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $name;
                    header("Location: dashboard.php");
                    exit;
                } else {
                    header("Location: signup.php?error=Registration failed. Please try again.");
                    exit;
                }
            } else {
                // Email already exists
                header("Location: signup.php?error=Email already exists in our records.");
                exit;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        header("Location: signup.php?error=All fields are required.");
        exit;
    }
} else {
    header("Location: signup.php?error=Invalid request method.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Signup Form</h1>

            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Enter Name</label>
                    <input type="text" id="username" name="username" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Enter Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Enter Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="password">Enter Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <input type="submit" value="Submit" class="btn">
            </form>
        </div>
    </div>
</body>
</html>
