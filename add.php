<?php
require_once "database.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
  header("location: login.php");
  exit;
}

$title = $title_err = "";
$address = $address_err = "";
$price = $price_err = "";
$m2 = $m2_err= "";
$rooms = $rooms_err = "";
$floors = $floors_err = "";
$balconies = $balconies_err = "";
$desc = "";
$picture = null;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['deleteid'])) {
        $deleteid = $_GET['deleteid'];
        $statment = "DELETE FROM main.immovables WHERE id == '$deleteid'";
        dbExec($statment);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST['title'])))
        $title_err = "Requried";
    else
        $title = trim($_POST['title']);

    if (empty(trim($_POST['address'])))
        $address_err = "Requried";
    else
        $address = trim($_POST['address']);

    if (empty(trim($_POST['price'])))
        $price_err = "Requried";
    elseif (!is_numeric($_POST['price']))
        $price_err = "Number";
    else
        $price = trim($_POST['price']);

    if (!is_numeric($rooms = trim($_POST['rooms'])))
        $rooms_err = "Number";

    if (!is_numeric($floors = trim($_POST['floors'])))
        $floors_err = "Number";

    if (!is_numeric($balconies = trim($_POST['balconies'])))
        $balconies_err = "Number";

    if (empty($title_err)
        && empty($address_err)
        && empty($price_err)
        && empty($rooms_err)
        && empty($floors_err)
        && empty($balconies_err)) {
        $m2 = $_POST['m2'];
        $rooms = $_POST['rooms'];
        $floors = $_POST['floors'];
        $balconies = $_POST['balconies'];
        $desc = $_POST['description'];
        $ownerid = getUserID($_SESSION['email']);
        $db = openOrCreateDB();
        $statment = "INSERT INTO main.immovables VALUES (
                      NULL,
                      '$title',
                      '$address',
                      '$price',
                      '$m2',
                      '$rooms',
                      '$floors',
                      '$balconies',
                      '$desc',
                      NULL,
                      '$ownerid',
                      NULL)";
        if (!$db->exec($statment))
            die("Error - Couldn't add");
    }
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
    getTableOfImmovables(queryUsersImmovables(getUserID($_SESSION['email'])));
    ?>
</table>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table>
        <tr><td>Title*</td><td><input type="text" name="title" value = <?php echo "$title_err"?>></td></tr>
        <tr><td>Address*</td><td><input type="text" name="address" value = <?php echo "$address_err"?>></td></tr>
        <tr><td>m2</td><td><input type="text" name="m2" value = <?php echo "$m2_err"?>></td></tr>
        <tr><td>Rooms</td><td><input type="text" name="rooms" value = <?php echo "$rooms_err"?>></td></tr>
        <tr><td>Floors</td><td><input type="text" name="floors" value = <?php echo "$floors_err"?>></td></tr>
        <tr><td>Balconies</td><td><input type="text" name="balconies" value = <?php echo "$balconies_err"?>></td></tr>
        <tr><td>Price*</td><td><input type="text" name="price" value = <?php echo "$price_err"?>></td></tr>
        <tr><td>Description</td><td><textarea name="description" rows="6" cols="18" maxlength="100"></textarea></td></tr>
        <tr><td colspan="2"><input id="add_button" type="submit" value="Add"></td></tr>
    </table>
</form>
</body>
</html>
