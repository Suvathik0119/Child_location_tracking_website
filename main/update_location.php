<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] == 'child') {
    $child_id = $_SESSION['user_id'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];

    $location = $lat . ',' . $lon;
    $stmt = $conn->prepare("UPDATE users SET location = ? WHERE id = ?");
    $stmt->bind_param("si", $location, $child_id);
    if ($stmt->execute()) {
        echo "Location updated";
    } else {
        echo "Error updating location";
    }
} else {
    echo "Invalid request";
}
?>
