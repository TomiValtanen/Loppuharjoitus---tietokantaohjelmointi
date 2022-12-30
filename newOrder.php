<?php
require("./inc/headers.php");
require("./inc/functions.php");
require("./productControl.php");
session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Kirjaudu sisään jatkaaksesi tilauksen tekemistä.";
    return;
}

$body = file_get_contents("php://input");
$order = json_decode($body);

if (!isset($order->tilauspvm) || !isset($order->summa) || !isset($order->tuotteet)) {
    http_response_code(400);
    echo "Tilaustiedoissa on puutteita.";
    return;
}
if(checkTuotteet($order)===false){
    http_response_code(400);
    echo "Tilaustiedoissa on puutteita.";
    return;
}

$orderDate=filter_var(preg_replace("([^0-9/] | [^0-9-])","",htmlentities($order->tilauspvm)));
$orderTotal=filter_var($order->summa,FILTER_SANITIZE_NUMBER_INT);

$db = createSqliteConnection("./bikestore.db");
try{
   
    $db->beginTransaction();

    $id=userId($_SESSION['username'],$db);
    
    $last_insert_id=newOrder($id,$orderDate,$orderTotal,$db);
    
    addNewOrderLines($order,$last_insert_id,$db);
     $db->commit();
    echo "Tilauksesi on vastaanotettu.";
}catch(Exception $e){
    $db->rollBack();
    echo "Jotain meni vikaan. " . $e->getMessage();
}

