<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] == 'parent') {
            header("Location: parent_dashboard.php");
        } else {
            header("Location: child_dashboard.php");
        }
    } else {
        echo "Invalid credentials";
    }
}
?>
<link rel="stylesheet" href="./assets/css/Rstyle.css">
<div class="container">
        <h1>Login Page</h1>
    <form method="POST" action="login.php">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <div class="button">
            <button class="btn" type="submit">Login</button><br>
        </div>
        <a href="./register.php">Register here...</a>
    </form>
</div>