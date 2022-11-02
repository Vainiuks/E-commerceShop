<?php

if (isset($_POST['loginSubmit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    include '../classes/database.class.php';
    include '../classes/login.class.php';
    include '../classes/login-controller.class.php';

    $loginController = new LoginController($username, $password);


    $loginController->loginUser();

    //Going back to index page after logging in
    header("location: ../index.php?error=none");
}
