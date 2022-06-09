<?php
require_once 'database.class.php';
session_start();

class Cart extends Database {

    public $productsIDArray;

    public  function addToCart($productID)
    {
        if (!empty($productID)) {
            $this->insertIntoTempSelectedItems($productID);
        }
    }

    public  function insertIntoTempSelectedItems($productID)
    {
        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('INSERT INTO productsID(userID, productID, quantity) VALUES (?,?,?);');
        $userID = $_SESSION['userID'];

        if (!$prepareStmt->execute(array($userID, $productID, 1))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $prepareStmt = null;
    }

    public  function insertIntoTempSelectedItemsWithQuantity($productID, $quantity)
    {
        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('INSERT INTO productsID(userID, productID, quantity) VALUES (?,?,?);');
        $userID = $_SESSION['userID'];

        if (!$prepareStmt->execute(array($userID, $productID, $quantity))) {
            $prepareStmt = null;
            header("location: ../product.php?error=stmtfailed");
            exit();
        }

        $prepareStmt = null;
    }

    public function getProductsFromCart()
    {
        // $dbConn = new Database();

        $sql = "
        SELECT product.productID, product.productType, product.productName, product.productPrice, product.productDescription, product.productImage, productsId.quantity
        FROM product
        LEFT JOIN productsid
        ON product.productID = productsid.productID
        WHERE product.productID = productsid.productID";

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
            // $dbConn = new Database();
            $prepareStmt = $this->connect()->prepare("DELETE FROM productsid WHERE productID='" . $productID . "'; ");
            $prepareStmt->execute();

            header("Location:" . $_SERVER['PHP_SELF']);
        }
    }

    public function updateProductQuantity($productID, $quantity) {

            // $dbConn = new Database();

            $prepareStmt = $this->connect()->prepare("UPDATE productsid SET quantity = $quantity WHERE productID = $productID ;");
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

    public function formatReceipt($purchaseAddress) {

        // $dbConn = new Database();
        $purchasedDate = date("Y-m-d h:i:sa");
        $totalCartPrice = $this->getCartPrice();
        $userID = $_SESSION['userID'];
        $prepareStmt = $this->connect()->prepare('INSERT INTO receipt(purchaseDate, purchaseAddress, totalPrice, userID) VALUES(?,?,?,?); ');

        if (!$prepareStmt->execute(array($purchasedDate, $purchaseAddress, $totalCartPrice , $userID))) {
            $prepareStmt = null;
            header("location: ../cart.php?error=stmtfailed");
            exit();
        }

        $this->getReceiptAndProductsID();
    }
    
   

    public function getReceiptAndProductsID() {

        // $dbConn = new Database();

        $userID = $_SESSION['userID'];
        $productsArr = array();
        $productsArr = $this->getProductsFromCart();
        $receiptID = array();
        
        $prepareStmt = $this->connect()->prepare("SELECT receiptID FROM receipt WHERE userID = $userID;");
        $prepareStmt->execute();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $receiptID = $row;
        }

        foreach($productsArr as $product) {
            $prepareStmt1 = $this->connect()->prepare("INSERT INTO selectedProductID(productID, receiptID, quantity) VALUES(?,?,?);");
            
            if(!$prepareStmt1->execute(array($product['productID'], $receiptID['receiptID'], $product['quantity']))) {
                $prepareStmt1 = null;
                header("location: ../cart.php?error=stmtfailed");
                exit();
            }
        }

        $this->clearSelectedProducts();

    }

     //Clear rows in temporary table
     public function clearSelectedProducts() {

        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('DELETE FROM productsID WHERE selectedID >= 1');

        if($prepareStmt->execute()) {
            header("location: ../index.php?error=none");
        }

    }
}

