<?php
require_once 'header.php';
require_once 'classes/product.class.php';
$productObj = new Product();
$products = array();
$products = $productObj->getProducts();
?>




<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="row">
        <div class="column1">
            <h1 class="settingsH1">Admin panel</h1>
            <hr class="settingsHR">
            <form action="includes/admin.inc.php" method="POST">
                <button class="columnBlockItem" type="submit" name="addItem">Add item</button>
                <button class="columnBlockItem" type="submit" name="deleteItem">Delete item</button>
                <button class="columnBlockItem" type="submit" name="updateItem">Update item</button>
            </form>
        </div>
        <div class="column2">


            <?php

            //Working on this
            $currentClickedButton = "";

            if (isset($_SESSION['currentClickedAdminPanelButton'])) {
                $currentClickedButton = $_SESSION['currentClickedAdminPanelButton'];
            }

            if ($currentClickedButton == "updateItem") {
            ?>
                <div class="settingsForm">
                    <h2>Update item</h2>
                    <form action="" method="POST">
                        <select style="margin-right: 200px;" name="productSelected">
                            <?php foreach ($products as $product) {
                                echo "<option name='productValue' value=".$product['productID']."> " . $product['productName'] . "-" . $product['productWeight'] . "-" . $product['productPrice'] . " </option>";
                            } ?>
                        </select>
                        <button class="settingsButton" type="submit" name="show_picked_item">Show item</button>
                    </form>




                    <?php
                        $productByID = array();
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            if (isset($_POST['show_picked_item'])){
                                $productByID = $productObj->getProductsById($_POST['productSelected']);
                            }
                        }
                        foreach($productByID as $productValueByID) {

                        }
                    ?>
                    <form action="includes/adminAction.inc.php" method="POST">
                        <p>Item name:</p>
                        <input class="settingsInput" type="text" name="itemName" placeholder="Item name..." value="<?php if(!empty($productByID)) {echo $productValueByID['productName'];}?>">
                        <p>Item price:</p>
                        <input class="settingsInput" type="text" name="itemPrice" placeholder="Item price..." value="<?php if(!empty($productByID)) {echo $productValueByID['productPrice'];}?>">
                        <p>Item weight:</p>
                        <input class="settingsInput" type="text" name="itemWeight" placeholder="Item weight..." value="<?php if(!empty($productByID)) {echo $productValueByID['productWeight'];}?>">
                        <p>Item description:</p>
                        <input class="settingsInput" type="text" name="itemDescription" placeholder="Item description" value="<?php if(!empty($productByID)) {echo $productValueByID['productDescription'];}?>"><br>
                        <input  type="hidden" name="productID" value="<?php if(!empty($productByID)) {echo $productValueByID['productID'];}?>">
                        <button class="settingsButton" type="submit" name="update_item_submit">Update item</button>
                    </form>
                </div>

            <?php
            }
            if ($currentClickedButton == "deleteItem") {
            ?>
                <div class="settingsForm">
                    <h2>Delete item</h2>
                    <form action="includes/adminAction.inc.php" method="POST">
                        <label> Select item: </label>
                        <select style="margin-right: 200px;" name="item_type_select">
                            <option value="productValue" value="empty"></option>
                            <?php foreach ($products as $product) {
                                echo "<option name='productValue' value=".$product['productID']."> " . $product['productName'] . "-" . $product['productWeight'] . "-" . $product['productPrice'] . " </option>";
                            } ?>
                        </select>
                        <button class="settingsButton" type="submit" name="delete_item_submit">Delete item</button>
                    </form>
                </div>

            <?php
            }
            if ($currentClickedButton == "addItem") {
            ?>
                <div class="settingsForm">
                    <h2>Add item</h2>

                    <form action="includes/adminAction.inc.php" method="POST" enctype="multipart/form-data">
                        <p>Item name:</p>
                        <input class="settingsInput" type="text" name="itemName" placeholder="Item name">
                        <p>Item type:</p>
                        <select name="item_type_select">
                            <option name="product_type_value" value="empty"></option>
                            <option name="product_type_value" value="drink">drink</option>
                            <option name="product_type_value" value="snack">snack</option>
                        </select>
                        <p>Item price:</p>
                        <input class="settingsInput" type="text" name="itemPrice" placeholder="Item price">
                        <p>Item weight:</p>
                        <input class="settingsInput" type="text" name="itemWeight" placeholder="Item weight">
                        <p>Item description:</p>
                        <input class="settingsInput" type="text" name="itemDescription" placeholder="Item description">
                        <p>Item image:</p>
                        <input type="file" name="file">
                        <button class="settingsButton" type="submit" name="add_item_submit">SUBMIT</button>
                    </form>

                </div>

            <?php
            }
            ?>

        </div>
    </div>

</body>

</html>