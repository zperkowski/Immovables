<?php
require_once "database.php";
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
  header("location: login.php");
  exit;
}

function getAllImmovables() {
    $result = queryImmovables();
    while ($row = $result->fetchArray()) {
        $echoRow = "<tr><td>".$row['title']."</td><td>".$row['address']."</td><td>".$row['m2']."</td><td>".$row['rooms']."</td><td>".$row['floors']."</td><td>".$row['balconies']."</td><td>".$row['price']."</td>";
        if ($row['ownerid'] == getUserID($_SESSION['email']))
            $echoRow = $echoRow."<td>Delete</td>";
        $echoRow = $echoRow."</tr>";
        echo $echoRow;
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
    <h1>Hi, <b><?php echo $_SESSION['email']; ?></b>. Welcome to our site.</h1>
</div>
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
        <th>Delete</th>
    </tr>
    <?php
    getAllImmovables();
    ?>
</table>

</body>
</html>
