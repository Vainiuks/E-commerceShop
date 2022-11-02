<?php
require_once 'header.php';
require_once 'classes/cart.class.php';
// include 'classes/cart-controller.class.php';
$cartObj = new Cart();
$products = array();
$products = $cartObj->getProductsFromCart();

$userType = "";

// if (isset($_SESSION['userType'])) {
//     $userType = $_SESSION['userType'];
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>

<body>
    <h1 class="shopping-cart-text">Confirm payment</h1>
        <div class="row2">
            <div class="column3" style="margin-left:160px;">
                <form action="includes/payment.inc.php" method="POST">
                    <p>First name:</p>
                    <input class="settingsInput" type="text" name="firstName" placeholder="First name" value=''>
                    <p>Email address:</p>
                    <input class="settingsInput" type="text" name="emailAddress" placeholder="Email address" value=''>
                    <p>City:</p>
                    <input class="settingsInput" type="text" name="city" placeholder="City" value=''>
                    <p>Postal code:</p>
                    <input class="settingsInput" type="text" name="postalCode" placeholder="LT-12345" value=''>
            </div>

            <div class="column4">
                <p>Last name:</p>
                <input class="settingsInput" type="text" name="lastName" placeholder="Last name" value=''>
                <p>Phone number:</p>
                <input class="settingsInput" type="text" name="phoneNumber" placeholder="Phone number" value=''>
                <p>Home address:</p>
                <input class="settingsInput" type="text" name="homeAddress" placeholder="Home address" value=''>
                <button class="settingsButton" style="width:310px; height:45px; margin-left: -1px;" name="confirmPayment" type="submit">Confirm payment</button>
            </div>

            </form>
        </div>


</body>

</html>