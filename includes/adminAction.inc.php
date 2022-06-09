<?php
require_once '../classes/admin-controller.class.php';
require_once '../classes/admin.class.php';
$adminController = new AdminController();
$adminObj = new Admin();

if(isset($_POST['add_item_submit'])) {
    $productName = $_POST['itemName'];
    $productType = $_POST['item_type_select'];
    $productPrice = $_POST['itemPrice'];
    $productWeight = $_POST['itemWeight'];
    $productDescription = $_POST['itemDescription'];

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $adminController->checkAddProductValues($productName, $productType, $productPrice, $productWeight, $productDescription, $fileName);
    $adminObj->uploadPicture($fileName, $fileTempName, $fileSize, $fileError, $fileType);

    header("location: ../adminpanel.php?itemadded");
}
if(isset($_POST['update_item_submit'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['itemName'];
    $productPrice = $_POST['itemPrice'];
    $productWeight = $_POST['itemWeight'];
    $productDescription = $_POST['itemDescription'];

    $adminObj->updateProduct($productName, $productPrice, $productWeight, $productDescription, $productID);

    header("location: ../adminpanel.php?");

}
if(isset($_POST['delete_item_submit'])) {
    $productID = $_POST['item_type_select'];

    $adminObj->deleteProduct($productID);

    header("location: ../adminpanel.php?updateddeleted");
}