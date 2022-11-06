<?php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles.css">
    <title>Document</title>
</head>
<body>
    

<?php

if (isset($_GET['error'])) {
    if ($_GET['error'] == "emptyfields") {
        echo '<p class="signup-error">Fill in all fields!</p>';
    } elseif ($_GET['error'] == "usernotfound") {
        echo '<p class="signup-error">User not found!</p>';
    } elseif ($_GET['error'] == 'wrongpassword') {
        echo '<p class="signup-error">Wrong password!</p>';
    }
}
?>

<div class="index-login-login">
    <form class="loginRegisterForm" action="includes/login.inc.php" method="POST">
        <h4>Login</h4>
        <?php
        echo '<h5> Enter your username:</h5>';
        if (isset($_GET['username'])) {
            $username = $_GET['username'];
            echo '<input class="inputField" type="text" name="username" placeholder="Username" value="' . $username . '">';
        } else {
            echo '<input  class="inputField" type="text" name="username" placeholder="Username">';
        }
        ?>
        <br>
        <h5> Enter your password:</h5>
        <input class="inputField" type="password" name="password" placeholder="Password">
        <br>
        <button class="submitButton" type="submit" name="loginSubmit">Login</button>
        <p>Don't have an account yet? <a class="hyperLink" href="signup.php">Sign up here!</a></p>
    </form>
</div>

</body>

</body>
</html>