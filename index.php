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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<h1 class="text-center">Hi, <b><?php echo getUserName($_SESSION['email']); ?></b>. Welcome to our site.</h1>
<div class="container">
    <div class="row">
        <div class="col mr-auto">
            <p><a href="index.php">Home</a></p>
            <p><a href="add.php">Add a new immovable</a></p>
            <p><a href="changePwd.php">Change password</a></p>
            <p><a href="logout.php">Sign out</a></p>
        </div>
        <div class="col-10 mr-auto">
            <table class="table">
                <thead>
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
                </thead>
                <?php
                getTableOfAllImmovables();
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
