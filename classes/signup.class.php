<?php

class Signup extends Database
{

    protected function setUser($username, $password, $email)
    {
        $prepareStmt = $this->connect()->prepare('INSERT INTO users(userUsername, userPassword, userEmail, userType) VALUES(?,?,?,?);');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$prepareStmt->execute(array($username, $hashedPassword, $email, "User"))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $prepareStmt = null;
    }

    protected function checkUser($username, $email)
    {
        $prepareStmt = $this->connect()->prepare('SELECT userUsername FROM users WHERE userUsername = ? OR userEmail = ?;');

        if (!$prepareStmt->execute(array($username, $email))) {
            $prepareStmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $results;
        if ($prepareStmt->rowCount() > 0) {
            $results = false;
        } else {
            $results = true;
        }

        return $results;
    }
}
