<?php
require_once 'database.class.php';
require_once 'send-email.class.php';
session_start();
class Cart extends Database {

    public $productsIDArray;
    
    public function getUserID() {
        $userID = '';
        if(!empty(isset($_SESSION['userID']))) {
            $userID = $_SESSION['userID'];
        } else {
            $userID = 9; // 9 means, that user purchased items without logging in
        }
        return $userID;
    }

    public  function addToCart($productID)
    {
        if (!empty($productID)) {
            $this->insertIntoTempCartItems($productID);
        }
    }

    public  function insertIntoTempCartItems($productID)
    {
        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('INSERT INTO cartItem(userID, productID, quantity) VALUES (?,?,?);');
        $userID = $this->getUserID();
        if (!$prepareStmt->execute(array($userID, $productID, 1))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $prepareStmt = null;
    }

    public  function insertIntoTempCartItemsWithQuantity($productID, $quantity)
    {
        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('INSERT INTO cartItem(userID, productID, quantity) VALUES (?,?,?);');
        $userID = $this->getUserID();
        if (!$prepareStmt->execute(array($userID, $productID, $quantity))) {
            $prepareStmt = null;
            header("location: ../product.php?error=stmtfailed");
            exit();
        }

        $prepareStmt = null;
    }

    public function getProductsFromCart()
    {
        $userID = $this->getUserID();
        $sql = "
        SELECT product.productID, product.productType, product.productName, product.productPrice, product.productDescription, product.productImage, cartItem.quantity
        FROM product
        LEFT JOIN cartItem
        ON product.productID = cartItem.productID
        WHERE product.productID = cartItem.productID 
        AND userID = $userID";

        $results = $this->mysqli()->query($sql);

        $simpleArray = array();

        if ($results->num_rows) {
            while ($row = $results->fetch_array()) {
                $simpleArray[] = $row;
            }
        }
        return $simpleArray;
    }

    public function deleteProductFromCart($productID)
    {   
       
        if ($productID != null) {
            $userID = $this->getUserID();
            $prepareStmt = $this->connect()->prepare("DELETE FROM cartItem WHERE productID='" . $productID . "' AND userID='" . $userID . "'; ");
            $prepareStmt->execute();

            header("Location:" . $_SERVER['PHP_SELF']);
        }
    }

    public function updateProductQuantityInCart($productID, $quantity) {

            // $dbConn = new Database();
            $userID = $this->getUserID();
            $prepareStmt = $this->connect()->prepare("UPDATE cartItem SET quantity = $quantity WHERE productID = $productID AND userID = $userID ;");
            $prepareStmt->execute();

            header("Location:" . $_SERVER['PHP_SELF']);

     }

    public function getCartPrice() {

        $products = $this->getProductsFromCart();

        $price = 0;
        foreach($products as $product) {
            $price = $price + ((double)$product['quantity'] * (double)$product['productPrice']);
        }

        return $price;
    }


    public function formatReceipt($firstName, $lastName, $emailAddress, $phoneNumber, $city, $homeAddress, $postalCode) {

        // $dbConn = new Database();
        $purchaseDate = date("Y-m-d h:i:sa");
        $totalCartPrice = $this->getCartPrice();
        $userID = $this->getUserID();
        $prepareStmt = $this->connect()->prepare('INSERT INTO receipt(purchaseDate, firstName, lastName, emailAddress, phoneNumber, city, homeAddress, postalCode, totalPrice, userID) VALUES(?,?,?,?,?,?,?,?,?,?); ');

        if (!$prepareStmt->execute(array($purchaseDate, $firstName, $lastName, $emailAddress, $phoneNumber, $city, $homeAddress, $postalCode, $totalCartPrice, $userID))) {
            $prepareStmt = null;
            header("location: ../payment.php?error=stmtfailed");
            exit();
        }

        $this->insertPurchasesProducts();
    }
    
    public function insertPurchasesProducts() {

        // $dbConn = new Database();
        $mail = new EmailSender();
        $productsArr = array();
        $productsArr = $this->getProductsFromCart();
        $receiptID = array();
        $userID = $this->getUserID();
        $prepareStmt = $this->connect()->prepare("SELECT receiptID FROM receipt WHERE userID = $userID;");
        $prepareStmt->execute();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $receiptID = $row;
        }

        foreach($productsArr as $product) {
            $prepareStmt1 = $this->connect()->prepare("INSERT INTO selectedProduct(productID, receiptID, quantity) VALUES(?,?,?);");
            
            if(!$prepareStmt1->execute(array($product['productID'], $receiptID['receiptID'], $product['quantity']))) {
                $prepareStmt1 = null;
                header("location: ../cart.php?error=stmtfailed");
                exit();
            }
        }
        
        $mail->sendEmail($productsArr);
        $this->clearCartItems();

    }

     //Clear rows in temporary table
     public function clearCartItems() {
        // $dbConn = new Database();
        $userID = $this->getUserID();
        $prepareStmt = $this->connect()->prepare("DELETE FROM cartItem WHERE userID = $userID;");

        if($prepareStmt->execute()) {
            echo "<script> window.location.href='../index.php'; </script>";
        }
    }

    public function getCartCount() {
        $userID = $this->getUserID();
        $count = array();
        $prepareStmt = $this->connect()->prepare("SELECT COUNT(*) as numberOfCartItems FROM cartItem WHERE userID = $userID;");

        $prepareStmt->execute();
        $count = $prepareStmt->fetchColumn();
        
        return $count;
    }
}

