<?php
include '../classes/database.class.php';
include '../classes/settings.class.php';
include '../classes/settings-controller.class.php';

$settingsController = new SettingsController();

if (isset($_POST['submitChangingEmail'])) {

    $currentEmail = $_POST['currentEmail'];
    $newEmail = $_POST['newEmail'];
    $repeatedEmail = $_POST['repeatNewEmail'];

    $settingsController->setEmailValues($newEmail, $repeatedEmail, $currentEmail);

    $settingsController->changeUserEmail();

    header("location: ../settings.php?success=emailchanged");
}

if (isset($_POST['submitChangingPassword'])) {

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $repeatedPassword = $_POST['repeatNewPassword'];

    $settingsController->setPasswordValues($newPassword, $repeatedPassword, $currentPassword);

    $settingsController->changeUserPassword();


    header("location: ../settings.php?success=passwordchanged");
}

if (isset($_POST['submitPersonalInformation'])) {

    $firstName = $_POST['firstName'];
    $profession = $_POST['profession'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $companyName = $_POST['companyName'];
    $education = $_POST['education'];


    $settingsController->setPersonalInformationValues($firstName, $profession, $lastName, $phoneNumber, $companyName, $education);

    $settingsController->changePersonalInformation();

    header("location: ../settings.php?success=informationchanged");
}
