<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "The username or email already entered";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>


<link rel="stylesheet" href="./assets/css/Rstyle.css">
<div class="container">
    <h1>Register Page</h1>
    <form method="POST" action="register.php">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Role:
        <div class="select-container">
            <select class="select-box" name="role">
                <option value="parent">Parent</option>
                <option value="child">Child</option>
            </select><br>
        </div> 
        <div class="button">
            <button class="btn" type="submit">Register</button><br>
        </div>
        <a href="./login.php">login here...</a>
    </form>
</div>