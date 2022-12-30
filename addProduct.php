<?php
require("./inc/headers.php");
require("./inc/functions.php");
require("./productControl.php");
session_start();


if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Et ole kirjautunut sisään.";
    return;
}

if ($_SESSION["username"] !== "admin@admin.bikestore.com") {
    http_response_code(403);
    echo $_SESSION['username'] . " Sinulla ei ole tarvittavia käyttöoikeuksia.";
    return;
}

$body = file_get_contents("php://input");
$product = json_decode($body);

if (!isset($product->nimi) || !isset($product->hinta) || !isset($product->trid) || !isset($product->kuva) || !isset($product->saldo) || !isset($product->koko)) {
    http_response_code(400);
    echo "Lisäämäsi tuotetiedot ovat väärin tai puutteelliset.";
    return;
}

$productName = filter_var($product->nimi, FILTER_SANITIZE_SPECIAL_CHARS);
$productName_sani = htmlspecialchars($productName, ENT_NOQUOTES, "ISO-8859-15");

$productPrice = filter_var($product->hinta, FILTER_SANITIZE_NUMBER_INT);

$productTrId = filter_var($product->trid, FILTER_SANITIZE_NUMBER_INT);

$productImage = filter_var($product->kuva, FILTER_SANITIZE_SPECIAL_CHARS);
$productImage_sani = htmlspecialchars($productImage, ENT_NOQUOTES, "ISO-8859-15");

$productCount = filter_var($product->saldo, FILTER_SANITIZE_NUMBER_INT);

$productSize = filter_var($product->koko, FILTER_SANITIZE_SPECIAL_CHARS);
$productSize_sani = htmlspecialchars($productSize, ENT_NOQUOTES, "ISO-8859-15");


try {
    addProduct($productName_sani, $productPrice, $productTrId, $productImage_sani, $productCount, $productSize_sani);
    http_response_code(200);
    echo "Tuote on lisätty!";
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
