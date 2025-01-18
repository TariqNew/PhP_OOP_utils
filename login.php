<?php
require_once 'config.php';
include 'Validation.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['username'];
    $password = $_POST['password'];

    
    if (!empty($name) && !empty($password)) {
       
        $validation = new Validation();
        $name = $validation->clean($name);
        $password = $validation->clean($password);

        try {
   
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $name, PDO::PARAM_STR);
            $stmt->execute();

         
            if ($stmt->rowCount() == 1) {
              
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

              
                if (password_verify($password, $user['password'])) {
                  
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_id'] = $user['id']; 
                    header("Location: dashboard.php");
                    exit;
                } else {
                    
                    header("Location: login.php?error=Incorrect username or password");
                    exit;
                }
            } else {

                header("Location: login.php?error=User not found or duplicate records");
                exit;
            }
        } catch (PDOException $e) {
            
            echo "Error: " . $e->getMessage();
        }
    } else {
       
        header("Location: login.php?error=All fields are required");
        exit;
    }
} else {

    header("Location: login.php?error=Invalid request method");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper" style="height: 300px;">
            <h1>Login Form</h1>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Enter Name</label>
                    <input type="text" name="username">
                </div>
                <div class="form-group">
                    <label for="">Enter Password</label>
                    <input type="text" name="password">
                </div>
                <input type="submit" value="login" name="submit">
            </form>
        </div>
    </div>
</body>
</html>