<?php
require_once 'database.class.php';

class Admin extends Database
{

    public function insertNewProduct($itemName, $itemType, $itemPrice, $itemWeight, $itemDescription, $itemImage)
    {

        $prepareStmt = $this->connect()->prepare('INSERT INTO product(productType, productName, productPrice, productWeight, productDescription, productImage) 
        VALUES(?,?,?,?,?,?)');

        if (!$prepareStmt->execute(array($itemType, $itemName, $itemPrice, $itemWeight, $itemDescription, "./includes/product_images/" . $itemImage))) {
            $prepareStmt = null;
            header("location: ../adminpanel.php?error=stmtfailed");
            exit();
        }

    }

    public function uploadPicture($fileName, $fileTempName, $fileSize, $fileError, $fileType)
    {

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowedExt = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowedExt)) {
            if ($fileError === 0) {
                if ($fileSize < 500000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'product_images/' . $fileNameNew;
                    move_uploaded_file($fileTempName, $fileDestination);
                } else {
                    header("location: ../adminpanel.php?error=filetoobig");
                }
            } else {
                header("location: ../adminpanel.php?error=erroruploadingfile");
            }
        } else {
            header("location: ../adminpanel.php?error=cantuploadfile");
        }
    }

    public function deleteProduct($productID) {
        $prepareStmt = $this->connect()->prepare("DELETE FROM product WHERE productID=?;");
        if(!$prepareStmt->execute(array($productID))) {
            $prepareStmt = null;
            header("location: ../adminpanel.php?productdeleted");
            exit();
        }
    }

    public function updateProduct($itemName, $itemPrice, $itemWeight, $itemDescription,$productID) {
        $dbConn = new Database();
        $prepareStmt = $dbConn->connect()->prepare("UPDATE `product` SET productName=?, productPrice=?, productWeight=?, productDescription=? WHERE productID = ?;");
 
        if (!$prepareStmt->execute(array($itemName, $itemPrice, $itemWeight, $itemDescription, $productID))) {
            $prepareStmt = null;
            header("location: ../cart.php?error=stmtfailed");
            exit();
        }

    }
}
