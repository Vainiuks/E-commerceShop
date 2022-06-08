<?php
require_once 'header.php';
require_once 'classes/product.class.php';
require_once 'classes/cart.class.php';
require_once 'classes/filter.class.php';

$filterObj = new Filter();
$productObj = new Product();
$products = array();


//Search
$searchValue = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['search_button_submit'])) {
        unset($products);
        $searchValue = $_POST['search_input'];
    }
} 

if($searchValue == null) {
    $products = $productObj->getProducts();
} 
else if(!empty($searchValue)){
    $products = $productObj->getProductsBySearchInput($searchValue);
}

//Sort
$sortValue = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit_sort_value'])) {
        unset($products);
        $sortValue = $_POST['sortBy'];
    }
}
if($sortValue==null || $sortValue=="empty") {
    $products = $productObj->getProducts();
} 
else if($sortValue=="sortASC") {
    $products = $productObj->getProductsAscOrder();
} 
else if($sortValue="sortDESC") {
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
            <label>Filters:</label><br>
            <input type="radio" name="filter_value" value="drink">
            <label>Drinks</label><br>
            <input type="radio" name="filter_value" value="snack">
            <label>Snacks</label><br>
            <input type="radio" name="filter_value" value="showAll">
            <label>Show all</label><br>
            <button type="submit" name="get_filter" class="submit_button">Filter</button>
        </form>
    </div>

    <div style="margin-top: 100px;" class="sortBys">
        <form method="POST">
            <label>Sort by:</label>
            <select name="sortBy" id="sortBy">
                <option name="sort_value" value="empty"></option>
                <option name="sort_value" value="sortDESC">Sort by price DESC </option>
                <option name="sort_value" value="sortASC">Sort by price ASC</option>
            </select>
            <button type="submit" name="submit_sort_value">Sort by</button>
        </form>
    </div>

    <div class="productsContainer">

        <?php



        foreach ($products as $product) {

// FOREACH

                if($product['productType'] == $filterValue) {
        ?>
                <div class="firstProductsColumn">
                    <a href="<?php printf('%s?productID=%s', 'product.php',  $product['productID']); ?>"><img src="<?php echo $product['productImage'] ?>" alt="product1" class="product_image"></a>
                    <div class="text-center">
                        <h6><?php echo  $product['productName'] ?></h6>

                        <div class="product-price">
                            <h6><?php echo  $product['productPrice']." €" ?></h6>
                        </div>
                        <form method="post">
                            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                            <input type="hidden" name="userID" value="<?php echo 1; ?>">
                            <button type="submit" name="product_submit" class="submit_button">Add to Cart</button>
                        </form>
                    </div>
                </div>
        <?php
                }

                if($filterValue == null || $filterValue == "showAll") {
                    ?>
                            <div class="firstProductsColumn">
                                <a href="<?php printf('%s?productID=%s', 'product.php',  $product['productID']); ?>"><img src="<?php echo $product['productImage'] ?>" alt="product1" class="product_image"></a>
                                <div class="text-center">
                                    <h6><?php echo  $product['productName'] ?></h6>
            
                                    <div class="product-price">
                                        <h6><?php echo  $product['productPrice']." €" ?></h6>
                                    </div>
                                    <form method="post">
                                        <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                                        <input type="hidden" name="userID" value="<?php echo 1; ?>">
                                        <button type="submit" name="product_submit" class="submit_button">Add to Cart</button>
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