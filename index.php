<?php
require_once 'header.php';
require_once 'classes/product.class.php';
require_once 'classes/cart.class.php';

$productObj = new Product();
$products = array();

$sortValue = null;
$searchValue = null;



echo '<script type="text/javascript">
       window.onload = function () { alert("Welcome"); } 
</script>'; 


//Search
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['search_button_submit'])) {
        $sortValue = "smth";
        $searchValue = $_POST['search_input'];
    }
}

if ($searchValue == null) {
    $products = $productObj->getProducts();
} else if (!empty($searchValue)) {
    $products = $productObj->getProductsBySearchInput($searchValue);
}

//Sort
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit_sort_value'])) {
        $searchValue = "smth";
        $sortValue = $_POST['sortBy'];
    }
}
if ($sortValue == null || $sortValue == "empty") {
    $products = $productObj->getProducts();
} else if ($sortValue == "sortASC") {
    $products = $productObj->getProductsAscOrder();
} else if ($sortValue = "sortDESC") {
    $products = $productObj->getProductsDescOrder();
}




//Add to cart item
$cartObj = new Cart();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['product_submit'])) {
        $cartObj->addToCart($_POST['productID']);
    }
}

//Filter by product type
$filterValue = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['get_filter'])) {
        $filterValue = $_POST['filter_value'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candy shop</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>

<body>

    <div class="productsFilter">
        <form action="" method="POST">
            <label class="filter_index">Filters:</label><br>
            <input class="filter_index" type="radio" name="filter_value" value="drink">
            <label class="filter_index">Drinks</label><br>
            <input type="radio" name="filter_value" value="snack">
            <label class="filter_index">Snacks</label><br>
            <input type="radio" name="filter_value" value="showAll">
            <label class="filter_index">Show all</label><br>
            <button class="product_filter_index" type="submit" name="get_filter">Filter</button>
        </form>
    </div>

    <div class="productsSortBy">
        <form method="POST">
            <label class="filter_index" style="margin-top:10px;">Sort by:</label>
            <select name="sortBy" id="sortBy">
                <option name="sort_value" value="empty"></option>
                <option name="sort_value" value="sortDESC">Sort by price DESC </option>
                <option name="sort_value" value="sortASC">Sort by price ASC</option>
            </select>
            <button class="product_filter_index" type="submit" name="submit_sort_value">Sort by</button>
        </form>
    </div>

    <div class="row1">

        <?php

        foreach ($products as $product) {

            if ($product['productType'] == $filterValue) {
        ?>
                <div class="firstProductsColumn">
                    <a href="<?php printf('%s?productID=%s', 'product.php',  $product['productID']); ?>"><img src="<?php echo $product['productImage'] ?>" alt="product1" class="product_image"></a>
                    <div class="text-center">
                        <h6 class="product_name_index"><?php echo  $product['productName'] ?></h6>

                        <div class="product-price">
                            <h6 class="product_price_index"><?php echo  $product['productPrice'] . " €" ?></h6>
                        </div>
                        <form method="post">
                            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                            <!-- <input type="hidden" name="userID" value="<?php echo 1; ?>"> -->
                            <?php if(isset($_SESSION['userID'])) { ?>
                                <button class="product_submit_index" type="submit" name="product_submit">Add to Cart</button>
                            <?php } else {

                            } ?>
                        </form>
                    </div>
                </div>
            <?php
            }

            if ($filterValue == null || $filterValue == "showAll") {
            ?>
                <div class="firstProductsColumn">
                    <a href="<?php printf('%s?productID=%s', 'product.php',  $product['productID']); ?>"><img src="<?php echo $product['productImage'] ?>" alt="product1" class="product_image"></a>
                    <div class="text-center">
                        <h6 class="product_name_index"><?php echo  $product['productName'] ?></h6>

                        <div class="product-price">
                            <h6 class="product_price_index"><?php echo  $product['productPrice'] . " €" ?></h6>
                        </div>
                        <form method="post">
                            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                            <input type="hidden" name="userID" value="<?php echo 1; ?>">
                            <?php if(isset($_SESSION['userID'])) { ?>
                                <button class="product_submit_index" type="submit" name="product_submit">Add to Cart</button>
                            <?php }  else {

                            } ?>
                        </form>
                    </div>
                </div>
        <?php
            }
        }
        ?>











    </div>

</body>

</html>

<?php
require 'footer.php';
?>