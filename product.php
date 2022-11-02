<?php
require_once "header.php";
require_once "classes/product.class.php";
require_once "classes/cart.class.php";
$productObj = new Product();
$product = array();
$cartObj = new Cart();
$currentProductsInCart = array();
$currentProductsInCart = $cartObj->getProductsFromCart();

$productID = "";
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];
}
$userID = "";
if(isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
}
$productAverage = $productObj->getProductAverage($productID);


$product = $productObj->getProductById($productID);
// $commentIsWritten = $productObj->getIfCommentIsWritten($userID, $productID);
$comments = $productObj->getProductDetails($productID);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit_product'])) {
        $quantity = $_POST['product_quantity'];
        $productID = $_GET['productID'];
        $counter = true;

        if ($_POST['product_quantity'] != "") {
            foreach ($currentProductsInCart as $value => $key) {
                if ($key['productID'] == $productID) {
                    $counter = false;
                }
            }

            if ($counter == true) {
                $cartObj->insertIntoTempCartItemsWithQuantity($productID, $quantity);
                header("Location:" . $_SERVER['PHP_SELF'] . "?productID=" . $productID);
            } else {
                echo '<script> alert("This product is already in your cart"); </script>';
            }
        } else {
            echo '<script> alert("Enter product quantity you want to buy"); </script>';
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit_comment'])) {
        $comment = $_POST['commentAboutProduct'];
        $rating = $_POST['rating'];

        $productObj->insertProductDetails($productID, $userID, $rating, $comment);
        header("Location:" . $_SERVER['PHP_SELF'] . "?productID=" . $productID);
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
    <div class="container123">
        <div class="row3">
            <?php foreach ($product as $value) { ?>

                <div class="column8">
                    <img style="width: 260px; height: 300px;" src="<?php echo $value['productImage']; ?>" alt="">
                </div>
                <div class="column9">
                    <form method="POST">
                        <input class="product_name" style="border:none; background-color:white; width: 550px; cursor: context-menu;" type="text" readonly="readonly" name="product_name" value="<?php echo $value['productName']; ?>"><br>
                        <label>Product price:</label>
                        <input class="product_price" style="border:none; background-color:white; width: 50px; cursor: context-menu;" type="text" readonly="readonly" name="product_price" value="<?php echo $value['productPrice'] . " €"; ?>"><br>
                        <label>Product weight:</label>
                        <input class="product_weight" style="border:none; background-color:white; width: 200px; cursor: context-menu;" type="text" readonly="readonly" name="product_weight" value="<?php echo $value['productWeight']; ?>"><br>
                        <label>Product description:</label><br>
                        <textarea class="product_description" style="width:550px; height:100; border:none; resize:none;" name="product_description" id="" cols="" rows="" readonly><?php echo $value['productDescription']; ?></textarea><br><br>
                        <label>Product rating:</label>
                        <input class="product_rating" style="border:none; background-color:white; width: 40px; cursor: context-menu;" type="text" readonly="readonly" name="product_rating" value="<?php echo (string)$productAverage; ?>"><br>
                        <label>Enter quantity:</label>
                        <input class="product_quantity" type="text" name="product_quantity" pattern="[0-9]+" value="1"><br>
                        <button class="newbutton" type="submit" name="submit_product">Add to cart</button>
                    </form>
                </div>

            <?php } ?>
        </div>

        <hr class="solid">

        <?php if($userID != "") { ?>
            <div class="row3">
                <form method="POST">
                    <label style="font-weight:bold; font-size:20px;">Select product rating:</label><br>
                    <select name="rating" class="rating">
                        <option value="empty">-- Rating -- </option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select><br>
                    <label style="font-weight:bold; font-size:20px;">Leave your comment:</label>
                    <textarea name="commentAboutProduct" id="" cols="132" rows="6"></textarea>
                    <button class="newbutton" name="submit_comment" style="margin-left: -0px; margin-top: 8px;">Submit</button>
                </form>
            </div>
            <hr class="solid" style="margin-top: 220px;">
        <?php } ?>
        <h2>Users feedback</h2>
        <?php foreach($comments as $comment => $key) { ?>
            <div class="row3" style="margin-top: 0px;">
                <div class="comment_container">
                <div class="dialog_box">
                    <div class="body">
                        <span class="tip tip-up"></span>
                        <p>Commented by:<?php echo " " . $key['userUsername']; ?> / Date:<?php echo " " . $key['commentDate']; ?></p>
                        <div class="message">
                            <span><?php echo $key['productComment']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <?php } ?>

    </div>



</body>

</html>