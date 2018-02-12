<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header("location: login.php");
    exit;
}

require "User.php";
$oldpassword = $password = $password2 = "";
$oldpassword_err = $password_err = $password2_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if old password is empty
    if (empty(trim($_POST['oldpassword']))) {
        $oldpassword_err = 'Please enter your old password.';
    } else {
        $oldpassword = trim($_POST['oldpassword']);
    }

    // Check if new password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your new password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Check if validation of new password is empty
    if (empty(trim($_POST['password2']))) {
        $password2_err = 'Please enter your new password again.';
    } else {
        $password2 = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($password_err) && empty($password2_err)) {
        // Check if passowrds are the same
        if ($password != $password2) {
            $password_err = $password2_err = "Passwords were different.";
        } else {
            if (changePassword($_SESSION['email'], $oldpassword, $password)) {
                header("location: index.php");
            } else {
                $email_err = 'Wrong password.';
            }
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
<a href="index.php.php">Home page</a>
<div id="div_login">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                <td>Old password</td>
                <td><input class="validation" type="password" name="oldpassword" id="input_login_oldpassword"></td>
            </tr>
            <tr>
                <td>New password</td>
                <td><input class="validation" type="password" name="password" id="input_login_password"></td>
            </tr>
            <tr>
                <td>Validate new password</td>
                <td><input class="validation" type="password" name="password2" id="input_login_password2"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="button_login" value="Change"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
