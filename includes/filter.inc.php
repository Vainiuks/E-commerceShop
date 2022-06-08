<?php

if (isset($_POST['search_button_submit'])) {
    
    $search_value = $_POST['search_input'];

    // include '../classes/filter.class.php';
    
    // $filterObj = new Filter();
    
    // $filterObj->setFilterValue($filter);

    header("location: ../index.php?error=". $search_value);
}



