<?php
include 'header.php';
include 'classes/cart.class.php';
// include 'classes/cart-controller.class.php';
$cartObj = new Cart();
$products = array();
$products = $cartObj->getProductsFromCart();

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


    <h1 class="shopping-cart-text">Shopping cart</h1>

    <div class="productsContainer">
        <h1>labas</h1>


        <div class="product-price">
                <h4 style="margin-left: 50px;">Total price:</h4>
                <h4><?php echo $price = $cartObj->getCartPrice(); ?> €</h4>
        </div>

        <form action="includes/payment.inc.php" method="POST">
        <label> Enter your home address</label>
        <input type="visible" name="home_address" value="" placeholder="Enter your address...">
        <button style="margin-left: 100px;" type="submit" name="confirm_payment" class="submit_button">Confirm payment</button>
        </form>

        <?php
        foreach ($products as $product) {

            $productID = $product['productID'];
        ?>
            <div class="firstProductsColumn">

                <?php
                ?>
                <a href="<?php printf('%s?productID=%s', 'product.php',  $product['productID']); ?>"><img src="<?php echo $product['productImage'] ?>" alt="product1" class="product_image"></a>
                <div class="text-center">
                    <h6><?php echo  $product['productName'] ?></h6>
                    <h6><?php echo  $product['productPrice']." €" ?></h6>
                    
                    
                    <!-- Quantity form -->
                    <form action="includes/cart.inc.php" method="POST">
                        <input type="hidden" value="<?php echo $product['productID'] ?>" name="productID">
                        <label>Quantity:</label>
                        <input type="visible" name="quantity" value="<?php echo $product['quantity']?>">
                        <button type="submit" name="change_quantity_button" class="submit_button">Save changes</button>
                    </form>

                    <!-- Delete product from cart -->
                    <form action="includes/cart.inc.php" method="post">
                        <input type="hidden" value="<?php echo $product['productID'] ?>" name="productID">
                        <button style="margin-top: 100px;" type="submit" name="remove_from_cart_submit" class="submit_button">Remove from Cart</button>
                    </form>
                </div>

            </div>

        <?php

        }

        ?>


</body>

</html>