<?php

if (isset($_POST['change_quantity_button'])) {
    
    //Getting data from form
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    
    include '../classes/cart-controller.class.php';
    
    $cart = new CartController($productID, $quantity);
    
    $cart->checkQuantity();

    header("location: ../cart.php?error=none");
}

if (isset($_POST['remove_from_cart_submit'])) {
    
    //Getting data from form
    $productID = $_POST['productID'];

    include '../classes/cart.class.php';
    $cart = new Cart();
    
    $cart->deleteProductFromCart($productID);

    header("location: ../cart.php?error=none");
}


// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (isset($_POST['remove_from_cart_submit'])) {
//         $cartObj->deleteProductFromCart($_POST['productID']);
//     }
// }
