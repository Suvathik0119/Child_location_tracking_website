<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header("Location: login.php");
    exit();
}

$parent_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $child_username = $_POST['child_username'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND role = 'child'");
    $stmt->bind_param("s", $child_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $child = $result->fetch_assoc();

    if ($child) {
        $child_id = $child['id'];
        $conn->query("INSERT INTO parent_child_relation (parent_id, child_id) VALUES ($parent_id, $child_id)");
    }
}

$children = $conn->query("SELECT users.* FROM users JOIN parent_child_relation ON users.id = parent_child_relation.child_id WHERE parent_child_relation.parent_id = $parent_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="./assets/css/dashboard.css" />
    <script
      src="https://kit.fontawesome.com/258d58ad40.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=_ENTER_YOUR_API_KEY_HERE....."></script>
    <script>
        function initMap(childId, lat, lon) {
            var location = {lat: parseFloat(lat), lng: parseFloat(lon)};
            var map = new google.maps.Map(document.getElementById('map-' + childId), {
                zoom: 10,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
</head>
<body>
<h1>Parent Dashboard</h1>

    <form method="POST" action="parent_dashboard.php">
        Connect Child by Username: <input type="text" name="child_username" required>
        <button type="submit">Connect</button>
    </form>
    <h2>Connected Children</h2>
    <ul>
        <?php while ($child = $children->fetch_assoc()): 
            $location = explode(',', $child['location']);
            $lat = $location[0];
            $lon = $location[1];
        ?>
            <li>
                <?php echo $child['username']; ?>
                <div id="map-<?php echo $child['id']; ?>" style="width:96%; margin: 2%; height:400px;"></div>
                <script>
                    initMap(<?php echo $child['id']; ?>, "<?php echo $lat; ?>", "<?php echo $lon; ?>");
                </script>
            </li>
        <?php endwhile; ?>
    </ul>



</body>
</html>
