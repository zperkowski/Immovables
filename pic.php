<?php
require_once "database.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <!--    <link rel="stylesheet" href="style.css">-->
</head>
<body>
<h1>Picture</h1>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['pictureid'])) {
        echo $_GET['pictureid'];
        $statment = "SELECT picture FROM main.immovables WHERE id == 19;";
        echo $statment;
        $db = openOrCreateDB();
        $result = $db->query($statment)->fetchArray();
        echo '<img src="data:image/jpeg;base64,' . base64_encode($result[0]) . '"/>';
        $db->close();
    }
}
?>
</body>
</html>
