<?php
session_start();
include_once 'config.php';
include_once 'Validation.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($phone) && !empty($password)) {
        // Sanitize inputs
        $validation = new Validation();
        $username = $validation->clean($username);
        $email = $validation->clean($email);
        $phone = $validation->clean($phone);
        $password = $validation->clean($password);

        try {
            // Update user information
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = :username, email = :email, phone = :phone, password = :password WHERE email = :current_email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':current_email', $_SESSION['email']);

            if ($stmt->execute()) {
                $_SESSION['email'] = $email; // Update session email if changed
                header("Location: settings.php?success=Profile updated successfully");
                exit;
            } else {
                header("Location: settings.php?error=Failed to update profile");
                exit;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        header("Location: settings.php?error=All fields are required");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Settings Page</h1>

            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php elseif (isset($_GET['success'])): ?>
                <div class="success-message">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Update Name</label>
                    <input type="text" id="username" name="username" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Update Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Update Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="password">Update Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <input type="submit" value="Change" class="btn">
            </form>
        </div>
    </div>
</body>
</html>
