<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'child') {
    header("Location: login.php");
    exit();
}

$child_id = $_SESSION['user_id'];

$parents = $conn->query("SELECT users.* FROM users JOIN parent_child_relation ON users.id = parent_child_relation.parent_id WHERE parent_child_relation.child_id = $child_id");
?>



<!DOCTYPE html>
<html>
  <head>
    <title>Child Dashboard</title>
    <link rel="stylesheet" href="./assets/css/dashboard.css" />
    <script
      src="https://kit.fontawesome.com/258d58ad40.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <h1>Child Dashboard</h1>

    <div class="container">
      <button class="share-btn" id="share-location">
        <i class="fa-solid fa-location-crosshairs"></i>Share
      </button>

      <h2>Connected Parents</h2>
      <ul>
        <?php while ($parent = $parents->fetch_assoc()): ?>
        <li><?php echo $parent['email']; ?></li>
        <?php endwhile; ?>
      </ul>
    </div>

    <script>
      document
        .getElementById("share-location")
        .addEventListener("click", function () {
          if (navigator.geolocation) {
            navigator.geolocation.watchPosition(function (position) {
              var lat = position.coords.latitude;
              var lon = position.coords.longitude;

              var xhr = new XMLHttpRequest();
              xhr.open("POST", "update_location.php", true);
              xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
              );
              xhr.onreadystatechange = function () {
                if (
                  xhr.readyState === XMLHttpRequest.DONE &&
                  xhr.status === 200
                ) {
                  console.log("Location updated");
                }
              };
              xhr.send("lat=" + lat + "&lon=" + lon);
            });
          } else {
            alert("Geolocation is not supported by this browser.");
          }
        });
    </script>
  </body>
</html>
