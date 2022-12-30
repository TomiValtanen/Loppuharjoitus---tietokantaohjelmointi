<?php
require("./inc/headers.php");
session_start();
require("./userControl.php");
require("./inc/functions.php");



$body= file_get_contents("php://input");
$user=json_decode($body);

if(!isset($user->userTag) || !isset($user->userPw) || !isset($user->etunimi) || !isset($user->sukunimi) || !isset($user->osoite) || !isset($user->postinro) || !isset($user->Postitmp) || !isset($user->puhnro)){
    http_response_code(400);
    echo "Rekisteröintitiedot ovat puutteellisia.";
    return;
}
$userEmail=filter_var($user->userTag,FILTER_SANITIZE_EMAIL);

$userFname=filter_var($user->etunimi,FILTER_SANITIZE_SPECIAL_CHARS);
$userFname_sani = htmlspecialchars($userFname, ENT_NOQUOTES,"ISO-8859-15");

$userLname=filter_var($user->sukunimi,FILTER_SANITIZE_SPECIAL_CHARS);
$userLname_sani = htmlspecialchars($userLname, ENT_NOQUOTES,"ISO-8859-15");

$userAdress=filter_var($user->osoite,FILTER_SANITIZE_SPECIAL_CHARS);
$userAdress_sani = htmlspecialchars($userAdress, ENT_NOQUOTES,"ISO-8859-15");

$userZip=filter_var($user->postinro,FILTER_SANITIZE_SPECIAL_CHARS);
$userZip_sani = htmlspecialchars($userZip, ENT_NOQUOTES,"ISO-8859-15");

$userCity=filter_var($user->Postitmp,FILTER_SANITIZE_SPECIAL_CHARS);
$userCity_sani = htmlspecialchars($userCity, ENT_NOQUOTES,"ISO-8859-15");

$userPhone=filter_var($user->puhnro,FILTER_SANITIZE_SPECIAL_CHARS);
$userPhone_sani = htmlspecialchars($userPhone, ENT_NOQUOTES,"ISO-8859-15");

if(checkEmail($userEmail)===true){
    http_response_code(400);
    echo "Kyseisellä sähköpostilla on käyttäjä luotu.";
    return;
}
try{
    newUser($userEmail,$user->userPw,$userFname_sani,$userLname_sani,$userAdress_sani,$userCity_sani,$userZip_sani,$userPhone_sani);

    $_SESSION['username'] = $user->userTag;
    
    http_response_code(200);
    echo "Käyttäjän ".$user->userTag." rekisteröinti onnistui.";
}catch(PDOException $pdoex) {
    returnError($pdoex);
}
