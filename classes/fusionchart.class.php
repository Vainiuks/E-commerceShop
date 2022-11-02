<?php 
require_once 'database.class.php';

class Queries extends Database {

    public function getDates() {

        $data = array();
        $prepareStmt = $this->connect()->prepare("SELECT year(userRegisteredDate) as Years ,month(userRegisteredDate) as Month, COUNT(userID) as totalUsers
        from users
        WHERE userRegisteredDate IS NOT NULL
        group by year(userRegisteredDate),month(userRegisteredDate)
        order by year(userRegisteredDate),month(userRegisteredDate)
        ");

        $prepareStmt->execute();

        while($row = $prepareStmt->fetchAll(PDO::FETCH_ASSOC)) {
            $data = $row;
        }

        return $data;
    }

    public function getMonthlyPurchases() {

        $monthlyIncome = array();

        $prepareStmt = $this->connect()->prepare("SELECT DATE_FORMAT(purchaseDate, '%Y-%m') as month, sum(totalPrice) as monthlyIncome
        from receipt
        group by month(purchaseDate)
        order by month(purchaseDate)
        ");

        $prepareStmt->execute();

        while($row = $prepareStmt->fetchAll(PDO::FETCH_ASSOC)) {
            $monthlyIncome = $row;
        }

        return $monthlyIncome;
    }

    public function getYearlyIncome() {
        $year = array();
        $currentYear = date("Y");
        $startOfTheYear = $currentYear . "-01-01";
        $endOfTheYear = $currentYear . "-12-31";

        $prepareStmt = $this->connect()->prepare("SELECT SUM(totalPrice) as yearlyIncome FROM receipt WHERE purchaseDate>=? AND purchaseDate<=?");
        
        if(!$prepareStmt->execute(array($startOfTheYear, $endOfTheYear))) {
            $prepareStmt = null;
            header("location: ../product.php?error=stmtfailed");
            exit();
        }

        $yearlyIncome = $prepareStmt->fetchColumn();

        return $yearlyIncome;
    }

    function sortArrayByNumericDescendingOrder($array, $key)
    {
        foreach ($array as $k => $v) {
            $b[] = strtolower($v[$key]);
        }
        arsort($b);
        foreach ($b as $k => $v) {
            $c[] = $array[$k];
        }

        $slicedArray = array_slice($c, 0, 5);

        return $slicedArray;
    }

    public function getTopFiveTrends() {

        $simpleArray = array();
  
        $sql = "
        SELECT p.productName as productName, SUM(s.quantity) as purchasedProducts
        FROM product p
        LEFT JOIN selectedProduct s
        ON s.productID = p.productID
        WHERE s.quantity IS NOT NULL  
        GROUP BY s.productID
        ";

        $results = $this->mysqli()->query($sql);

        if ($results !== false) {
            while ($row = $results->fetch_array()) {
                $simpleArray[] = $row;
            }
        }

        $sorted = $this->sortArrayByNumericDescendingOrder($simpleArray, 'purchasedProducts');
        
        return $sorted;
    }

}
