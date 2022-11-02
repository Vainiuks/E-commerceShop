<?php
require_once 'cart.class.php';

class PaymentController extends Cart
{

    private $firstName;
    private $lastName;
    private $emailAddress;
    private $phoneNumber;
    private $city;
    private $homeAddress;
    private $postalCode;

    public function __construct($firstName, $lastName, $emailAddress, $phoneNumber, $city, $homeAddress, $postalCode)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
        $this->phoneNumber = $phoneNumber;
        $this->city = $city;
        $this->homeAddress = $homeAddress;
        $this->postalCode = $postalCode;
    }

    public function checkPaymentInput()
    {
        if ($this->inputHandling() == false) {
            header("location: ../payment.php?error=emptyfields");
            exit();
        }

        if ($this->emailHandling() == false) {
            header("location: ../payment.php?error=wrongemail");
            exit();
        }

        // if ($this->postalCodeHandling() == false) {
        //     header("location: ../payment.php?error=wrongpostalcode");
        //     exit();
        // } else {
        //     header("location: ../payment.php?error=viskassuperduper");
        //     exit();
        // }

        $cart = new Cart();
        $this->formatReceipt($this->firstName, $this->lastName, $this->emailAddress, $this->phoneNumber, $this->city, $this->homeAddress, $this->postalCode);


    }

    private function inputHandling()
    {
        $result;

        if (empty($this->firstName) || empty($this->lastName) || empty($this->emailAddress) || empty($this->phoneNumber) || empty($this->city)|| empty($this->homeAddress) || empty($this->postalCode)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

   private function emailHandling()
    {
        $result;

        if (!filter_var($this->emailAddress, FILTER_VALIDATE_EMAIL) ? $result = false : $result = true);

        return $result;
    } 

    // private function postalCodeHandling()
    // {
    //     $result;
    //     $splittedPostalCode[] = explode("-", $this->postalCode);
    //     // $counter = 0;
    //     foreach($splittedPostalCode as $value) {
    //             // if($value == 'LT') {
                    
    //             // } else {
    //                 if(is_numeric($value) ? $result = true : $result = false);
    //             // }
    //     }

    //     return $result;
    // } 
}
