<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <?php
        require "User.php";
        $user = new User($_POST["login"], $_POST["password"]);
    ?>
</body>
</html>


