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
<body class="registrationBody">
    
<?php

//Handling error and show them on page, not in URL
if (isset($_GET['error'])) {
    if ($_GET['error'] == "emptyfields") {
        echo '<p class="signup-error">Fill in all fields!</p>';
    } else if ($_GET['error'] == "invalidusername") {
        echo '<p class="signup-error">Invalid username!</p>';
    } else if ($_GET['error'] == "invalidemail") {
        echo '<p class="signup-error">Invalid e-mail!</p>';
    } else if ($_GET['error'] == "passwordnotmatch") {
        echo '<p class="signup-error">Passwords do not match!</p>';
    } else if ($_GET['error'] == "usernameoremailtaken") {
        echo '<p class="signup-error">Username or email is taken!</p>';
    }
}

?>

<div class="index-login-login">
    <form class="loginRegisterForm" action="includes/signup.inc.php" method="POST">
        <h4>Sign up</h4>
        <?php
        echo '<h5> Enter your username:</h5>';
        if (isset($_GET['username'])) {
            $username = $_GET['username'];
            echo '<input class="inputField" type="text" name="username" placeholder="Username" value="' . $username . '">';
        } else {
            echo '<input class="inputField" type="text" name="username" placeholder="Username">';
        }
        ?>
        <br>
        <h5> Enter your password:</h5>
        <input class="inputField" type="password" name="password" placeholder="Password"> <br>
        <h5> Repeat your password:</h5>
        <input class="inputField" type="password" name="repeatPassword" placeholder="Repeat password"> <br>
        
        <?php
        echo '<h5> Enter your email:</h5>';
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            echo '<input class="inputField" type="text" name="email" placeholder="Email" value="' . $email . '">';
        } else {
            echo '<input class="inputField" type="text" name="email" placeholder="Email">';
        }
        ?>
        <br>
        <button class="submitButton" type="submit" name="submitSignup">SIGN UP</button>
        <p>Already have an account? <a class="hyperLink" href="login.php">Login here!</a></p>
    </form>
</div>


</body>
</html>