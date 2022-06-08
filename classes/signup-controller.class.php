<?php

class SignupController extends Signup
{

    private $username;
    private $password;
    private $passwordRepeat;
    private $email;

    public function __construct($username, $password, $passwordRepeat, $email)
    {

        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->email = $email;
    }

    public function signupUser()
    {
        if ($this->inputHandling() == false) {
            header("location: ../signup.php?error=emptyfields&username=" . $this->username . "&email=" . $this->email);
            exit();
        }

        if ($this->usernameHandling() == false) {
            header("location: ../signup.php?error=invalidusername&email=" . $this->email);
            exit();
        }

        if ($this->emailHandling() == false) {
            header("location: ../signup.php?error=invalidemail&username=" . $this->username);
            exit();
        }

        if ($this->passwordHandling() == false) {
            header("location: ../signup.php?error=passwordnotmatch&username=" . $this->username . "&email=" . $this->email);
            exit();
        }

        if ($this->usernameEmailTakenCheck() == false) {
            header("location: ../signup.php?error=usernameoremailistaken&username=" . $this->username . "&email=" . $this->email);
            exit();
        }

        $this->setUser($this->username, $this->password, $this->email);
    }

    private function inputHandling()
    {
        $result;

        if (empty($this->username) or empty($this->password) or empty($this->passwordRepeat) or empty($this->email)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function usernameHandling()
    {
        $result;

        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function emailHandling()
    {
        $result;

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function passwordHandling()
    {
        $result;

        if ($this->password !== $this->passwordRepeat) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function usernameEmailTakenCheck()
    {
        $result;

        if (!$this->checkUser($this->username, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}
