<?php
require "User.php";
$email = $number = $password = $password2 = "";
$email_err = $password_err = $password2_err = "";

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

    // Check if password is empty
    if (empty(trim($_POST['password2']))) {
        $password2_err = 'Please enter your password.';
    } else {
        $password2 = trim($_POST['password']);
    }

    $name = trim($_POST['name']);
    $number = trim($_POST['number']);

    // Validate credentials
    if (empty($email_err) && empty($password_err) && empty($password2_err)) {
        // Check if passowrds are the same
        if ($password != $password2) {
            $password_err = $password2_err = "Passwords were different.";
        } else {
            // Check if user exists
            $statment = "SELECT * FROM main.users WHERE email = '$email'";
            $user = dbQuery($statment)->fetchArray();
            if ($user == null) {
                createUser(NULL, $email, $number, $password, $name);
                session_start();
                $_SESSION['email'] = $email;
                header("location: index.php");
            } else {
                $email_err = 'User already exists.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="input_validation.js"></script>
    <title>Login</title>
</head>
<body>
<h1 class="text-center">Register</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col mr-auto">
            <p><a href="login.php">Login</a></p>
            <p><a href="register.php">Register</a></p>
        </div>
        <div class="col-8 mr-auto">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input class="text-success" type="text" name="name" id="input_login_name"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input class="text-success" type="email" name="email" id="input_login_email"></td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td><input class="text-success" type="tel" name="number" id="input_login_number"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input class="text-success" type="password" name="password" id="input_login_password"></td>
                    </tr>
                    <tr>
                        <td>Validate password</td>
                        <td><input class="text-success" type="password" name="password2" id="input_login_password2"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="button_login" value="Register"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div>
</body>
</html>
