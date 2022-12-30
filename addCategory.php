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

if (!isset($product->trnimi)) {
    http_response_code(400);
    echo "Lisäämäsi tuotekategorian tiedot ovat väärin tai puutteelliset.";
    return;
}
$productCategory = filter_var($product->trnimi, FILTER_SANITIZE_SPECIAL_CHARS);
$productCategory_sani = htmlspecialchars($productCategory, ENT_NOQUOTES, "ISO-8859-15");

try {
    addCategory($productCategory_sani);
    http_response_code(200);
    echo "Kategoria on lisätty!";
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
