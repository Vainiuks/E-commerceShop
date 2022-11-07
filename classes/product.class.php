<?php
// require_once 'database.class.php';
// session_start();

class Product extends Database
{

    public function getProducts() 
    {
        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('SELECT * FROM product;');
        $prepareStmt->execute();

        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;

    }

    public function getProductsAscOrder() {
        $prepareStmt = $this->connect()->prepare('SELECT * FROM product ORDER BY productPrice ASC;');
        $prepareStmt->execute();

        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;

    }

    public function getProductsDescOrder() {
        $prepareStmt = $this->connect()->prepare('SELECT * FROM product ORDER BY productPrice DESC;');
        $prepareStmt->execute();

        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;

    }

    public function getProductsBySearchInput($searchInput) {
        $prepareStmt = $this->connect()->prepare('SELECT * FROM product WHERE productName LIKE? ;');
        $prepareStmt->execute(array("%$searchInput%"));

        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;
    }



    public function getProductsById($productID) {

        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('SELECT * FROM product WHERE productID=?;');
        if(!$prepareStmt->execute(array($productID))) {
            $prepareStmt = null;
            header("location: ../adminpanel.php?error=stmtfailed");
            exit();
        }
        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;
    }


    public function getProductById($productID) {

        // $dbConn = new Database();
        $prepareStmt = $this->connect()->prepare('SELECT * FROM product WHERE productID=?;');
        if(!$prepareStmt->execute(array($productID))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;
    }

    public function getFilteredProducts($checkBoxValues, $minPrice, $maxPrice, $sortByPrice, $sortByName) {
        $sql = [];
        $parameters = [];

    
        if(!empty($checkBoxValues)) {
            foreach($checkBoxValues as $boxValue => $value) {
                $sql[] = " productType = ?";
                $parameters[] = $value;
            }
        }

        $query = "SELECT * FROM product";

        if ($sql) {
            $query .= ' WHERE ( ' . implode(' OR ', $sql) . ' )';
        } 

        if(!empty($minPrice) && !empty($maxPrice)) {
            $priceQuery = " AND ( productPrice >= ? AND productPrice <= ? )";
            $parameters[] = $minPrice;
            $parameters[] = $maxPrice;
            $query .= $priceQuery;
        }

        $sortQuery = '';
        if(!empty($sortByPrice) || $sortByPrice != '') {
            $sortQuery = " ORDER BY  productPrice {$sortByPrice} ";
        } else if (!empty($sortByName) || $sortByName != '') {
            $sortQuery = " ORDER BY  productName {$sortByName} ";
        }
        $query .= $sortQuery;

        $prepareStmt = $this->connect()->prepare($query);

        if ($parameters) {
            if(!$prepareStmt->execute($parameters)) {
                $prepareStmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
        }
        $productArray = array();

        while($row = $prepareStmt->fetch(PDO::FETCH_ASSOC)) {
            $productArray[] = $row;
        }

        return $productArray;
    } 

    public function getProductAverage($productID) {
        $prepareStmt = $this->connect()->prepare('SELECT AVG(productRating) FROM productDetails WHERE productID=?');

        if(!$prepareStmt->execute(array($productID))) {
            $prepareStmt = null;
            header("location: ../product.php?error=stmtfailed");
            exit();
        }

        $productAverage = $prepareStmt->fetchColumn();

        return round($productAverage, 1);
    }

    public function getIfCommentIsWritten($userID, $productID) {
        $prepareStmt = $this->connect()->prepare('SELECT productComment FROM productDetails WHERE userID=? AND productID=?');

        if(!$prepareStmt->execute(array($userID, $productID))) {
            $prepareStmt = null;
            header("location: ../product.php?error=stmtfailed");
            exit();
        }

        $commentIsWritten = false;
        $productComment = $prepareStmt->fetchColumn();
        if(preg_match('/[A-Za-z]/', $productComment) || preg_match('/[0-9]/', $productComment)) {
            $commentIsWritten = true;
        }

        return $commentIsWritten;
    }

    public function getProductDetails($productID) {

        $sql = "
        SELECT productDetails.productComment, productDetails.commentDate, users.userUsername
        FROM productDetails
        LEFT JOIN users
        ON productDetails.userID = users.userID
        WHERE productID = $productID";

        $results = $this->mysqli()->query($sql);

        $simpleArray = array();

        if ($results->num_rows) {
            while ($row = $results->fetch_array()) {
                $simpleArray[] = $row;
            }
        }
        return $simpleArray;
    }

    public function insertProductDetails($productID, $userID, $rating, $comment) {

        $productDetails = $this->getProductDetails($productID);
        $currentDate = date("Y-m-d H:i:s");
        $exists = false;
        foreach($productDetails as $value) {
            if($productID == $value['productID'] && $userID == $value['userID']) {
                $exists = true;
            } 
        }

        if($exists == false) {
            $prepareStmt = $this->connect()->prepare('INSERT INTO productDetails(userID, productID, productRating, productComment, commentDate) 
            VALUES(?,?,?,?,?)');
    
            if (!$prepareStmt->execute(array($userID, $productID, $rating, $comment, $currentDate))) {
                $prepareStmt = null;
                header("location: ../product.php?error=stmtfailed");
                exit();
            }
        } else {
            if(!preg_match('/[A-Za-z]/', $comment) && !preg_match('/[0-9]/', $comment)) {
                $prepareStmt = $this->connect()->prepare("UPDATE productDetails SET productRating=? WHERE productID = ? AND userID = ?;");
 
                if (!$prepareStmt->execute(array($rating, $productID, $userID))) {
                    $prepareStmt = null;
                    header("location: ../product.php?error=stmtfailed");
                    exit();
                }
            } elseif(!preg_match('/[0-9]/', $rating)) {
                $prepareStmt = $this->connect()->prepare("UPDATE productDetails SET productComment=? WHERE productID = ? AND userID = ?;");
 
                if (!$prepareStmt->execute(array($comment, $productID, $userID))) {
                    $prepareStmt = null;
                    header("location: ../product.php?error=stmtfailed");
                    exit();
                }
            }
        }
    }

    function sortProductsByPriceDESC($array, $key)
    {
        foreach ($array as $k => $v) {
            $b[] = strtolower($v[$key]);
        }
        arsort($b);

        foreach ($b as $k => $v) {
            $c[] = $array[$k];
        }

        return $c;
    }

    function sortProductsByPriceASC($array, $key)
    {
        foreach ($array as $k => $v) {
            $b[] = strtolower($v[$key]);
        }
        asort($b);

        foreach ($b as $k => $v) {
            $c[] = $array[$k];
        }

        return $c;
    }
    

    function sortProductsByNameDESC($array, $key)
    {
        foreach ($array as $k => $v) {
            $b[] = strtolower($v[$key]);
        }
        arsort($b);

        foreach ($b as $k => $v) {
            $c[] = $array[$k];
        }

        return $c;
    }

    function sortProductsByNameASC($array, $key)
    {
        foreach ($array as $k => $v) {
            $b[] = strtolower($v[$key]);
        }
        asort($b);

        foreach ($b as $k => $v) {
            $c[] = $array[$k];
        }

        return $c;
    }

}

