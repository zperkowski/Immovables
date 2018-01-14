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
    <!--    <link rel="stylesheet" href="style.css">-->
</head>
<body>
<div>
    <h1>Your properties, <b><?php echo getUserName($_SESSION['email']); ?></b>.</h1>
</div>
<p><a href="index.php">Home</a></p>
<p><a href="add.php">Add a new immovable</a></p>
<p><a href="logout.php">Sign Out of Your Account</a></p>

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

</body>
</html>
