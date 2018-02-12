<?php
require_once "database.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
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
<div>
    <h1>Hi, <b><?php echo getUserName($_SESSION['email']); ?></b>. Welcome to our site.</h1>
</div>
<p><a href="index.php">Home</a></p>
<p><a href="add.php">Add a new immovable</a></p>
<p><a href="changePwd.php">Change password</a></p>
<p><a href="logout.php">Sign Out of Your Account</a></p>

<table>
    <tr>
        <th>Title</th>
        <th>Address</th>
        <th>m2</th>
        <th>Rooms</th>
        <th>Floors</th>
        <th>Balconies</th>
        <th>Price</th>
        <th></th>
    </tr>
    <?php
    getTableOfAllImmovables();
    ?>
</table>

</body>
</html>
