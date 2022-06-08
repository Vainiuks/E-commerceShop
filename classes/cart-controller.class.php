<?php 
// include 'cart.class.php';

class CartController extends Cart{

    private $productID;
    private $quantity;

    public function __construct($productID, $quantity)
    {
        $this->productID = $productID;
        $this->quantity = $quantity;
    }

    public function checkQuantity()
    {

        if ($this->inputHandling() == false) {
            header("location: ../cart.php?error=emptyfields");
            exit();
        }

        if ($this->quantityHandling() == false) {
            header("location: ../cart.php?error=quantitycontainsonlynumbers");
            exit();
        }

        // $cart = new Cart();

        $this->updateProductQuantity($this->productID, $this->quantity);
    }

    private function inputHandling()
    {
        $result;

        if (empty($this->quantity)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function quantityHandling()
    {
        $result;

        if (!empty($this->quantity)) {
            if (!preg_match("/^[0-9]*$/", $this->quantity)) {
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
