<?php

if(isset($_POST['confirm_payment'])) {
    
    $home_address = $_POST['home_address'];

    include '../classes/payment-controller.class.php';
    
    $payment = new PaymentController($home_address);

    $payment->checkHomeAddress();

    header("location: ../cart.php?error=none");

}