<?php
require("./inc/headers.php");
require("./inc/functions.php");
require("./productControl.php");

$product_category = filter_input(INPUT_GET, "category",FILTER_SANITIZE_SPECIAL_CHARS);
$product_category_sani = htmlspecialchars($product_category, ENT_NOQUOTES,"ISO-8859-15");

try{

    $categories=selectCategories($product_category_sani);

    http_response_code(200);
    echo json_encode($categories);
}catch(PDOException $pdoex){
    returnError($pdoex);
}

