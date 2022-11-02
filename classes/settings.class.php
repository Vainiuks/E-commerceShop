<?php
session_start();

class Settings extends Database
{


    public function setPersonalInformation($firstName, $lastName, $profession, $phoneNumber, $companyName, $education)
    {

        // Logged in user ID
        $userID = "";
        $userID = $_SESSION['userID'];

        $getPersonalInfo = $this->connect()->prepare('SELECT * FROM personalinfo WHERE userID=?;');

        if (!$getPersonalInfo->execute(array($userID))) {
            $getPersonalInfo = null;
            header("location: ../settings.php?error=sqlerror");
            exit();
        }

        if ($getPersonalInfo->rowCount() == 0) {
            $insertPersonalInformation = $this->connect()->prepare('INSERT INTO personalinfo(firstName, lastName, phoneNumber, profession, companyName, education, userID) VALUES(?,?,?,?,?,?,?);');

            if (!$insertPersonalInformation->execute(array($firstName, $lastName, $profession, $phoneNumber, $companyName, $education, $userID))) {
                $insertPersonalInformation = null;
                header("location: ../settings.php?error=sqlerror");
                exit();
            }

            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['phoneNumber'] = $phoneNumber;
            $_SESSION['profession'] = $profession;
            $_SESSION['companyName'] = $companyName;
            $_SESSION['education'] = $education;

            $getPersonalInfo = null;
            $insertPersonalInformation = null;
        } else {
            $updatePersonalInformation = $this->connect()->prepare('UPDATE personalinfo SET firstName=?, lastName=?, phoneNumber=?, profession=?, companyName=?, education=? WHERE userID=?;');

            if (!$updatePersonalInformation->execute(array($firstName, $lastName, $phoneNumber, $profession, $companyName, $education, $userID))) {
                $updatePersonalInformation = null;
                header("location: ../settings.php?error=sqlerror");
                exit();
            }

            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['phoneNumber'] = $phoneNumber;
            $_SESSION['profession'] = $profession;
            $_SESSION['companyName'] = $companyName;
            $_SESSION['education'] = $education;

            $updatePersonalInformation = null;
        }
    }

    public function changePassword($currentPassword, $newPassword, $repeatedPassword)
    {
        $username = "";
        $username = $_SESSION['username'];
        $prepareStmt = $this->connect()->prepare('SELECT userPassword FROM users WHERE userUsername=?');


        if (!$prepareStmt->execute(array($username))) {
            $prepareStmt = null;
            header("location: ../settings.php?error=sqlerror");
            exit();
        }

        $hashedPassword = $prepareStmt->fetchAll(PDO::FETCH_ASSOC);
        $verifyPassword = password_verify($currentPassword, $hashedPassword[0]['userPassword']);

        if ($verifyPassword == false) {
            $prepareStmt = null;
            header("location: ../settings.php?error=wrongpassword");
            exit();
        } elseif ($verifyPassword == true) {

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $prepareStmt2 = $this->connect()->prepare('UPDATE users SET userPassword=? WHERE userUsername=?');

            if (!$prepareStmt2->execute(array($hashedPassword, $username))) {
                $prepareStmt2 = null;
                header("location: ../settings.php?error=sqlerror");
                exit();
            }
        }
    }

    public function changeEmail($newEmail, $currentEmail)
    {

        $isValidCurrentEmail = $this->checkForEmail($currentEmail);

        if($isValidCurrentEmail == true) {
            $prepareStmt = $this->connect()->prepare('UPDATE users SET userEmail=? WHERE userEmail=?');
            
            if (!$prepareStmt->execute(array($newEmail, $currentEmail))) {
                $prepareStmt = null;
                header("location: ../settings.php?error=sqlerror");
                exit();
            }
            
            $_SESSION['userEmail'] = $newEmail;
            
            $prepareStmt = null;
        } else {
            header("location: ../settings.php?error=wrongemail");
            exit();
        }
    }

    public function checkForEmail($currentEmail) {

        $prepareStmt = $this->connect()->prepare('SELECT userEmail FROM users WHERE userEmail = ?');

        if (!$prepareStmt->execute(array($currentEmail))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $results;
        if ($prepareStmt->rowCount() > 0) {
            $results = true;
        } else {
            $results = false;
        }

        return $results;
    }


}
