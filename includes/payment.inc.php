<?php

if(isset($_POST['confirmPayment'])) {
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $city = $_POST['city'];
    $homeAddress = $_POST['homeAddress'];
    $postalCode = $_POST['postalCode'];

    require_once '../classes/payment-controller.class.php';

    $payment = new PaymentController($firstName, $lastName, $emailAddress, $phoneNumber, $city, $homeAddress, $postalCode);

    $payment->checkPaymentInput();

    // header("location: ../payment.php?error=none");

}