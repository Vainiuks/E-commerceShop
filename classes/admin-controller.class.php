<?php
require_once 'admin.class.php';

class AdminController extends Admin {

    private $itemName;
    private $itemType;
    private $itemPrice;
    private $itemWeight;
    private $itemDescription;
    private $itemImage;

    public function checkAddProductValues($itemName, $itemType, $itemPrice, $itemWeight, $itemDescription, $itemImage) {
        $this->itemName = $itemName;
        $this->itemType = $itemType;
        $this->itemPrice = $itemPrice;
        $this->itemWeight = $itemWeight;
        $this->itemDescription = $itemDescription;
        $this->itemImage = $itemImage;

        if ($this->inputHandling() == false) {
            header("location: ../adminpanel.php?error=emptyfields");
            exit();
        }

        // if ($this->priceHandling() == false) {
        //     header("location: ../adminpanel.php?error=wrongpriceformat");
        //     exit();
        // }

        $this->insertNewProduct($this->itemName, $this->itemType, $this->itemPrice, $this->itemWeight, $this->itemDescription, $this->itemImage);
        
    }

    public function checkUpdateItemValues() {

    }

    public function checkDeleteItemValues() {

    }

    public function inputHandling() {
        $result;

        if (empty($this->itemName) || $this->itemType == "empty" || empty($this->itemPrice) || empty($this->itemWeight) || empty($this->itemDescription)  || empty($this->itemImage)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    public function priceHandling() {
        $result;

        if (!empty($this->price)) {
            if (!preg_match("/^[0-9]*$/", $this->price)) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }


}