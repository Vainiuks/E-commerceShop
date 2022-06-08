<?php
require_once "header.php";
require_once "classes/product.class.php";
require_once "classes/cart.class.php";
$productObj = new Product();
$product = array();

$productID = "";
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];
}

$product = $productObj->getProductById($productID);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit_product'])) {
        $quantity = $_POST['product_quantity'];
        $productID = $_GET['productID'];
        $cart = new Cart();
        $cart->insertIntoTempSelectedItemsWithQuantity($productID, $quantity);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>

<body>

    <div class="productPage">
        <?php
        foreach ($product as $value) { ?>

            <form method="POST">
                <img style="width: 350px; height: 400px;" src="<?php echo $value['productImage']; ?>" alt="">
                <input class="product_name" style="border:none; background-color:white; width: 600px; cursor: context-menu;" type="text" readonly="readonly" name="product_name" value="<?php echo $value['productName']; ?>"><br>
                <label>Product price:</label>
                <input class="product_price" style="border:none; background-color:white; width: 200px; cursor: context-menu;" type="text" readonly="readonly" name="product_price" value="<?php echo $value['productPrice']; ?>"><br>
                <label>Product weight:</label>
                <input class="product_weight" style="border:none; background-color:white; width: 200px; cursor: context-menu;" type="text" readonly="readonly" name="product_weight" value="<?php echo $value['productWeight']; ?>"><br>
                <label>Product description:</label><br>
                <textarea style="width:1000px; height:60; border:none; resize:none;" name="product_description" id="" cols="" rows="" readonly><?php echo $value['productDescription']; ?></textarea><br>
                <!-- <input class="product_description" style="border:none; background-color:white; width: 200px; cursor: context-menu;" type="text" readonly="readonly" name="product_description" value="<?php echo $value['productDescription']; ?>"><br> -->
                <label>Enter quantity:</label>
                <input class="product_quantity" type="text" name="product_quantity" pattern="[0-9]+"><br>

                <button class="settingsButton" type="submit" name="submit_product">Add to cart</button>
            </form>

        <?php }
        ?>
    </div>


</body>

</html>