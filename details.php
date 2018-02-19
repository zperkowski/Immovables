<?php
require_once "database.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("location: login.php");
    exit;
}
$buyer = -1;
$id = -1;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['buyer']))
        $buyer = $_GET['buyer'];
    $id = $_GET['id'];
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
<h1 class="text-center">Your properties, <b><?php echo getUserName($_SESSION['email']); ?></b>.</h1>
<div class="container">
    <div class="row">
        <div class="col mr-auto">
            <p><a href="index.php">Home</a></p>
            <p><a href="add.php">Add a new immovable</a></p>
            <p><a href="changePwd.php">Change password</a></p>
            <p><a href="logout.php">Sign out</a></p>
        </div>
        <div class="col-10 mr-auto">
            <?php
            if (isset($_GET['buyer'])) {
                $statment = "UPDATE immovables SET buyerid = '$buyer' WHERE id = '$id';";
                $good = dbExec($statment);
                if ($good) {
                    $statment = "SELECT ownerid FROM main.immovables WHERE id = '$id';";
                    $result = dbQuery($statment)->fetchArray();
                    $owneremail = getUserEmail($result['ownerid']);
                    echo "<h1>Successful<br>Owner email: $owneremail</h1>";
                } else
                    die("Error");
            }
            if ($id > -1 && !isset($_GET['buyer']))
                getTableOfImmovableByID($id);
            ?>
        </div>
    </div>
</div>
</body>
</html>
