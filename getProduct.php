<?php
require("./inc/headers.php");
require("./inc/functions.php");
require("./productControl.php");

$product_id_sani = filter_input(INPUT_GET, "productId", FILTER_SANITIZE_NUMBER_INT);


try {

    $product = getProduct($product_id_sani);

    http_response_code(200);
    echo json_encode($product);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
