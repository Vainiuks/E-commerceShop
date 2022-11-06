<?php

class LoginController extends Login
{
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function loginUser() {
        if ($this->inputHandling() == false) {
            header("location: ../login.php?error=emptyfields&username=" . $this->username);
            exit();
        }

        $this->getUser($this->username, $this->password);
        $this->getPersonalInformation();
    }

    private function inputHandling() {
        $result;

        if (empty($this->username) or empty($this->password)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}



