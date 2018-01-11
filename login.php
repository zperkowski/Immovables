<?php
require "User.php";
$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = 'Please enter username.';
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        $statment = "SELECT * FROM main.users WHERE email = '$email'";
        $user = dbQuery($statment)->fetchArray();
        if ($user != null && password_verify($password, $user['pwd'])) {
            session_start();
            $_SESSION['email'] = $email;
            header("location: index.php");
        } else {
            $password_err = 'The password you entered was not valid.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="input_validation.js"></script>
    <title>Login</title>
</head>
<body>
<div id="div_login">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                <td>Email</td>
                <td><input class="validation" type="email" name="email" id="input_login_email"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input class="validation" type="password" name="password" id="input_login_password"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="button_login" value="Login"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
