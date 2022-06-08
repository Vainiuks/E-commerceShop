<?php
session_start();
$_SESSION['currentClickedSettingsButton'] = "accountSettings";


if (isset($_POST['changeEmail'])) {
   $_SESSION['currentClickedSettingsButton'] = "changeEmail";
}

if (isset($_POST['changePassword'])) {
   $_SESSION['currentClickedSettingsButton'] = "changePassword";
}

if (isset($_POST['accountSettings'])) {
   $_SESSION['currentClickedSettingsButton'] = "accountSettings";
}

header("location: ../settings.php");
