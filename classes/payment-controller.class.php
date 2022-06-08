<?php
require_once 'cart.class.php';

class PaymentController extends Cart
{

    private $home_address;

    public function __construct($home_address)
    {
        $this->home_address = $home_address;
    }

    public function checkHomeAddress()
    {
        if ($this->inputHandling() == false) {
            header("location: ../cart.php?error=emptyfields");
            exit();
        }

        if ($this->checkIfCartIsEmpty() == false) {
            header("location: ../cart.php?error=emptycart");
            exit();
        }
        // $cart = new Cart();

        $this->formatReceipt($this->home_address);


    }

    private function inputHandling()
    {
        $result;

        if (empty($this->home_address)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function checkIfCartIsEmpty()
    {
        $result;
        // $cart = new Cart();

        $cartPrice = $this->getCartPrice();

        if ($cartPrice == 0) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }


}
