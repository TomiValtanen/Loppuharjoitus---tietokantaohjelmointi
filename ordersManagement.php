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
$order = json_decode($body);

if (!isset($order->tilausnro) || !isset($order->tila)) {
    http_response_code(400);
    echo "Tilaustiedot ovat puutteelliset.";
    return;
}

$orderNumber = filter_var($order->tilausnro, FILTER_SANITIZE_NUMBER_INT);

$orderState = filter_var($order->tila, FILTER_SANITIZE_SPECIAL_CHARS);
$orderState_sani = htmlspecialchars($orderState, ENT_NOQUOTES, "ISO-8859-15");

$db = createSqliteConnection("./bikestore.db");

try {
    $db->beginTransaction();

    orderManagement($orderState_sani,$orderNumber,$db);

    $db->commit();
    http_response_code(200);
    echo "Tilauksen tila on päivitetty onnistuneesti.";
} catch (Exception $e) {
    $db->rollBack();
    echo "Jotain meni vikaan. " . $e->getMessage();
}
