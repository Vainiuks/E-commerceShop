<?php
require_once 'header.php';
require_once 'classes/product.class.php';
require_once 'classes/cart.class.php';

$productObj = new Product();
$products = array();
$cartObj = new Cart();
$currentProductsInCart = array();
$currentProductsInCart = $cartObj->getProductsFromCart();

$sortValue = null;
$searchValue = null;
$_SESSION['minPrice'] = "";
$_SESSION['maxPrice'] = "";


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
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     if (isset($_POST['getFilter'])) {
//         if (isset($_POST['sorting'])) {
//             $value = $_POST['sorting'];
//             // var_export($value);
//             if ($value == 'DESC') {
//                 $products = $productObj->sortProductsByPriceDESC($products, 'productPrice');
//             } else if ($value == 'ASC') {
//                 $products = $productObj->sortProductsByPriceASC($products, 'productPrice');
//             } else if ($value == 'nameZa') {
//                 $products = $productObj->sortProductsByNameDESC($products, 'productName');
//             } else if ($value == 'nameAz') {
//                 $products = $productObj->sortProductsByNameASC($products, 'productName');
//             }
//         }
//     }
// }

$filterValue = null;

//Add to cart item
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['product_submit'])) {
        $productID = $_POST['productID'];
        $exists = false;
        foreach ($currentProductsInCart as $value => $key) {
            if ($key['productID'] == $productID) {
                $exists = true;
            }
        }
        if ($exists == false) {
            $cartObj->addToCart($_POST['productID']);
            header("Location:" . $_SERVER['PHP_SELF']);
        } else {
            echo '<script> alert("This product is already in your cart"); </script>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['getFilter'])) {
        $minPrice = '';
        $maxPrice = '';
        $sortByPrice = '';
        $sortByName = '';
        $checkBoxFilters = array();
        if (isset($_POST['sorting'])) {
            $value = $_POST['sorting'];
            if($value == 'DESC') {
                $sortByPrice = 'DESC';
                $_SESSION['sortType'] = 'DESC';
            } else if ($value == 'ASC') {
                $sortByPrice = 'ASC';
                $_SESSION['sortType'] = 'ASC';
            }
            if($value == 'nameAz') {
                $sortByName = 'ASC';
                $_SESSION['sortType'] = 'nameAz';
            } else if ($value == 'nameZa') {
                $sortByName = 'DESC';
                $_SESSION['sortType'] = 'nameZa';
            }
        }

        foreach ($_POST as $key => $value) {
            if($key == 'drink') {
                $_SESSION['drinkFilter'] = 'drink';
            }
            if($key == 'snack') {
                $_SESSION['snackFilter'] = 'snack';
            }
            if($key == 'cookies') {
                $_SESSION['cookiesFilter'] = 'cookies';
            }
            if ($value == 'on') {
                $checkBoxFilters[] = $key;
            } else if (is_numeric($value)) {
                if ($key == 'minPrice') {
                    $minPrice = $value;
                    $_SESSION['minPrice'] = $value;
                } else if ($key == 'maxPrice') {
                    $maxPrice = $value;
                    $_SESSION['maxPrice'] = $value;
                }
            }
        }
        $products = $productObj->getFilteredProducts($checkBoxFilters, $minPrice, $maxPrice, $sortByPrice, $sortByName);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['resetFilters'])) {
        $_SESSION['minPrice'] = "";
        $_SESSION['maxPrice'] = "";
        $_SESSION['drinkFilter'] = '';
        $_SESSION['cookiesFilter'] = '';
        $_SESSION['snackFilter'] = '';
        $_SESSION['sortType'] = 'empty';
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/js/my.js"></script>
    <title>Candy shop</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>

<body>
    <form method="POST">
        <div class="sidenav">
            <button type="button" class="collapsible">Sort by</button>
            <div class="content">
                <label>Sort by:</label><br>
                <select name="sorting" id="sorting">
                    <option value="empty" <?=$_SESSION['sortType'] == 'empty' ? ' selected="selected"' : '';?>></option>
                    <option value="DESC" <?=$_SESSION['sortType'] == 'DESC' ? ' selected="selected"' : '';?>>Descending order</option>
                    <option value="ASC" <?=$_SESSION['sortType'] == 'ASC' ? ' selected="selected"' : '';?>>Ascending order</option>
                    <option value="nameAz" <?=$_SESSION['sortType'] == 'nameAz' ? ' selected="selected"' : '';?>>Order by name [A-Z]</option>
                    <option value="nameZa" <?=$_SESSION['sortType'] == 'nameZa' ? ' selected="selected"' : '';?>>Order by name [Z-A]</option>
                </select><br>
            </div>

            <button type="button" class="collapsible">Type</button>
            <div class="content">
                <label>Drinks</label>
                <input type="checkbox" id="checkBox" name="drink" <?php if(!empty($_SESSION['drinkFilter'])) echo "checked='checked'"; ?> /><br>
                <label>Snacks</label>
                <input type="checkbox" id="checkBox" name="snack" <?php if(!empty($_SESSION['snackFilter'])) echo "checked='checked'"; ?> /><br>
                <label>Cookies</label>
                <input type="checkbox" id="checkBox" name="cookies" <?php if(!empty($_SESSION['cookiesFilter'])) echo "checked='checked'"; ?> />
            </div>

            <button type="button" class="collapsible">Price</button>
            <div class="content">
                <label>Min price</label><br>
                <input type="text" name="minPrice" value="<?php echo $_SESSION['minPrice']; ?>"><br>
                <label>Max price</label><br>
                <input type="text" name="maxPrice" value="<?php echo $_SESSION['maxPrice']; ?>">
            </div>
        </div>
        <div>
            <input type="submit" value="Filter" name="getFilter" style="
            position:fixed; 
            margin-top:865px; 
            margin-left: 10px;
            background-color: #222;
            border-radius: 4px;
            border-style: none;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            line-height: 1.5;
            outline: none;
            overflow: hidden;
            padding: 9px 20px 8px;
            text-align: center;
            width: 130px;
            ">
            <input type="submit" name="resetFilters" value="Reset filters" style="
            position:fixed; 
            margin-top:865px; 
            margin-left: 180px;
            background-color: #222;
            border-radius: 4px;
            border-style: none;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            line-height: 1.5;
            outline: none;
            overflow: hidden;
            padding: 9px 20px 8px;
            text-align: center;
            width: 130px;
            ">
        </div>
    </form>



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
                            <button class="product_submit_index" type="submit" name="product_submit">Add to Cart</button>

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
                            <button class="product_submit_index" type="submit" name="product_submit">Add to Cart</button>
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

<style>

</style>

<script>

    function unCheck() {

        $('input[type=checkbox]').each(function() {
            this.checked = false;
        });

    }

    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    var mySelect = document.getElementById("sorting");
    mySelect.options.selectedIndex = <?php echo $_SESSION["sortType"]; ?>
</script>