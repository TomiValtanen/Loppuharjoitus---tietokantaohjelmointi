<?php

function returnError(PDOException $pdoex) {
    echo header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $pdoex->getMessage());
    echo json_encode($error);
    exit;
}
// tarkistaa ,että tuotteet on laitettuna
function checkTuotteet($order)
{
    $isSet = true;
    foreach ($order->tuotteet as $value) {
        if (!isset($value->tuoteId) || !isset($value->kpl)) {
            return $isSet = false;
        }
    }
    return $isSet;
}