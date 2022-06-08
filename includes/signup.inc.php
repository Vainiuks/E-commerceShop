<?php

if (isset($_POST['submitSignup'])) {

    //Getting data from form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $email = $_POST['email'];

    //Includes are needed
    include '../classes/database.class.php';
    include '../classes/signup.class.php';
    include '../classes/signup-controller.class.php';
    $signupController = new SignupController($username, $password, $repeatPassword, $email);

    //Running error handlings
    $signupController->signupUser();

    //Going back to front page -> index page
    header("location: ../index.php?error=none");
}
