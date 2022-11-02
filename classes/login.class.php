<?php
require_once 'database.class.php';
session_start();

class Login extends Database
{

    protected function getUser($username, $password)
    {
        $prepareStmt = $this->connect()->prepare('SELECT userPassword FROM users WHERE userUsername = ? OR userEmail = ?;');

        if (!$prepareStmt->execute(array($username, $password))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if ($prepareStmt->rowCount() == 0) {
            $prepareStmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }

        $hashedPassword = $prepareStmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $hashedPassword[0]["userPassword"]);

        if ($checkPassword == false) {
            $prepareStmt = null;
            header("location: ../login.php?error=wrongpassword&username=" . $username);
            exit();
        } elseif ($checkPassword == true) {
           
            $prepareStmt = $this->connect()->prepare('SELECT * FROM users WHERE userUsername = ? OR userEmail = ? AND userPassword = ?;');

            if (!$prepareStmt->execute(array($username, $username, $password))) {
                $prepareStmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            if ($prepareStmt->rowCount() == 0) {
                $prepareStmt = null;
                header("location: ../login.php?error=usernotfound");
                exit();
            }

            $user = $prepareStmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['userID'] = $user[0]["userID"];
            $_SESSION['username'] = $user[0]["userUsername"];
            $_SESSION['userType'] = $user[0]['userType'];
            $_SESSION['userEmail'] = $user[0]['userEmail'];

            $prepareStmt = null;
        }

        $prepareStmt = null;
    }

    protected function getPersonalInformation()
    {

        $userID = "";
        $userID = $_SESSION['userID'];

        $prepareStmt = $this->connect()->prepare('SELECT * FROM personalinfo WHERE userID = ?;');

        if (!$prepareStmt->execute(array($userID))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $personalInfo = $prepareStmt->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['infoID'] = $personalInfo[0]["infoID"];
        $_SESSION['firstName'] = $personalInfo[0]["firstName"];
        $_SESSION['lastName'] = $personalInfo[0]["lastName"];
        $_SESSION['phoneNumber'] = $personalInfo[0]["phoneNumber"];
        $_SESSION['profession'] = $personalInfo[0]["profession"];
        $_SESSION['companyName'] = $personalInfo[0]["companyName"];
        $_SESSION['education'] = $personalInfo[0]["education"];
    }
}
