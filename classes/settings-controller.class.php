<?php


class SettingsController extends Settings
{

    private $currentEmail;
    private $newEmail;
    private $repeatedEmail;


    public function __construct()
    {
    }


    public function setEmailValues($newEmail, $repeatedEmail, $currentEmail)
    {
        $this->currentEmail = $currentEmail;
        $this->newEmail = $newEmail;
        $this->repeatedEmail = $repeatedEmail;
    }

    public function changeUserEmail()
    {

        if ($this->checkEmailEmptyFields() == false) {
            header("location: ../settings.php?error=emptyfields");
            exit();
        } else if ($this->checkNewEmailIsValid() == false) {
            header("location: ../settings.php?error=newemailnotvalid");
            exit();
        } else if ($this->checkRepeatedEmailIsValid() == false) {
            header("location: ../settings.php?error=repeatedemailnotvalid");
            exit();
        } else if ($this->checkEmailsAreEqual() == false) {
            header("location: ../settings.php?error=emailsnotequal&newEmail=" . $this->newEmail . "&repeatedEmail=" . $this->repeatedEmail);
            exit();
        } 

        $this->changeEmail($this->newEmail, $this->currentEmail);
    }

    private function checkEmailEmptyFields()
    {

        $result;

        if (empty($this->newEmail) or empty($this->repeatedEmail)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function checkNewEmailIsValid()
    {

        $result;

        if (!filter_var($this->newEmail, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function checkRepeatedEmailIsValid()
    {

        $result;

        if (!filter_var($this->repeatedEmail, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function checkEmailsAreEqual()
    {

        $result;

        if ($this->newEmail != $this->repeatedEmail) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    ////// Change password

    private $newPassword;
    private $repeatedPassword;
    private $currentPassword;

    public function setPasswordValues($newPassword, $repeatedPassword, $currentPassword)
    {
        $this->newPassword = $newPassword;
        $this->repeatedPassword = $repeatedPassword;
        $this->currentPassword = $currentPassword;
    }

    public function changeUserPassword()
    {

        if ($this->checkPasswordFields() == false) {
            header("location: ../settings.php?error=emptyfields");
            exit();
        }

        if ($this->checkPasswordsAreEqual() == false) {
            header("location: ../settings.php?error=passwordsnotequal");
            exit();
        }

        // if ($this->checkPasswordsAreEqual() == true && $this->checkPasswordFields() == true) {
        //     header("location: ../settings.php?success=passwordhasbeenchanged");
        //     exit();
        // }

        $this->changePassword($this->currentPassword, $this->newPassword, $this->repeatedPassword);
    }

    private function checkPasswordFields()
    {
        $result;

        if (empty($this->currentPassword) or empty($this->newPassword) or empty($this->repeatedPassword)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function checkPasswordsAreEqual()
    {
        $result;

        if ($this->newPassword != $this->repeatedPassword) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }


    /////////////// Personal information

    private $firstName;
    private $profession;
    private $lastName;
    private $phoneNumber;
    private $companyName;
    private $education;

    public function setPersonalInformationValues($firstName, $profession, $lastName, $phoneNumber, $companyName, $education)
    {
        $this->firstName = $firstName;
        $this->profession = $profession;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->companyName = $companyName;
        $this->education = $education;
    }

    public function changePersonalInformation()
    {

        if ($this->firstNameHandling() == false) {
            header("location: ../settings.php?error=namestartswithuppercase");
            exit();
        }

        if ($this->lastNameHandling() == false) {
            header("location: ../settings.php?error=lastnamestartswithuppercase");
            exit();
        }

        if ($this->professionHandling() == false) {
            header("location: ../settings.php?error=professionstartswithuppercase");
            exit();
        }

        if ($this->companyNameHandling() == false) {
            header("location: ../settings.php?error=companynamestartswithuppercase");
            exit();
        }

        if ($this->phoneNumberHandling() == false) {
            header("location: ../settings.php?error=phonenumbercantincludeletters");
            exit();
        }

        if ($this->educationHandling() == false) {
            header("location: ../settings.php?error=educationstartswithuppercase");
            exit();
        }

        $this->setPersonalInformation($this->firstName, $this->lastName, $this->profession, $this->phoneNumber, $this->companyName, $this->education);
    }

    private function firstNameHandling()
    {
        $result;

        if (!empty($this->firstName)) {
            //Checks if word starts with uppercase
            if (!preg_match('~^\p{Lu}~u', $this->firstName) and preg_match("/^[a-zA-Z0-9]*$/", $this->firstName)) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    private function lastNameHandling()
    {
        $result;

        if (!empty($this->lastName)) {
            //Checks if word starts with uppercase
            if (!preg_match('~^\p{Lu}~u', $this->lastName) and preg_match("/^[a-zA-Z0-9]*$/", $this->lastName)) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    private function professionHandling()
    {
        $result;

        if (!empty($this->profession)) {
            //Checks if word starts with uppercase
            if (!preg_match('~^\p{Lu}~u', $this->profession) and preg_match("/^[a-zA-Z0-9]*$/", $this->profession)) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    private function companyNameHandling()
    {
        $result;

        if (!empty($this->companyName)) {
            //Checks if word starts with uppercase
            if (!preg_match('~^\p{Lu}~u', $this->companyName) and preg_match("/^[a-zA-Z0-9]*$/", $this->companyName)) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    private function phoneNumberHandling()
    {
        $result;

        if (!empty($this->phoneNumber)) {
            if (!preg_match("/^[0-9]*$/", $this->phoneNumber)) {
                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }

    private function educationHandling()
    {
        $result;

        if (!empty($this->lastName)) {
            //Checks if word starts with uppercase
            if (!preg_match('~^\p{Lu}~u', $this->education)) {
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
