<?php
session_start();

$_SESSION['currentClickedAdminPanelButton'] = "";

if (isset($_POST['updateItem'])) {
    $_SESSION['currentClickedAdminPanelButton'] = "updateItem";
}

if (isset($_POST['addItem'])) {
    $_SESSION['currentClickedAdminPanelButton'] = "addItem";
}

if (isset($_POST['deleteItem'])) {
    $_SESSION['currentClickedAdminPanelButton'] = "deleteItem";
}

header("location: ../adminpanel.php");
