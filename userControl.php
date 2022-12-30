<?php
require("./dbConnection.php");
//Hakee salasanan
function password($userEmail)
{

    $db = createSqliteConnection("./bikestore.db");

    $sql = "SELECT salasana FROM asiakas WHERE sposti=?";
    $statement = $db->prepare($sql);
    $statement->execute(array($userEmail));

    return $statement->fetchColumn();
}
// Tarkistaa ettei ole kahta samaa sähköpostiosoitetta ja palauttaa true / false
function checkEmail($userEmail)
{

    $db = createSqliteConnection("./bikestore.db");
    $sql = "SELECT sposti FROM asiakas WHERE sposti=?";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $userEmail, PDO::PARAM_STR);
    $statement->execute();
    $email = $statement->fetchColumn();

    return $email === $userEmail ? true : false;
}
// Luodaan uusi käyttäjä
function newUser($userEmail, $userPw, $userFname, $userLname, $userAdress, $userCity, $userZip, $userPhone)
{
    $db = createSqliteConnection("./bikestore.db");

    $pw = password_hash($userPw, PASSWORD_DEFAULT);

    $sql = "INSERT INTO asiakas (sposti,salasana,etunimi,sukunimi,osoite,postinro,Postitmp,puhnro) values (?,?,?,?,?,?,?,?)";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $userEmail, PDO::PARAM_STR);
    $statement->bindParam(2, $pw);
    $statement->bindParam(3, $userFname, PDO::PARAM_STR);
    $statement->bindParam(4, $userLname, PDO::PARAM_STR);
    $statement->bindParam(5, $userAdress, PDO::PARAM_STR);
    $statement->bindParam(6, $userZip, PDO::PARAM_STR);
    $statement->bindParam(7, $userCity, PDO::PARAM_STR);
    $statement->bindParam(8, $userPhone, PDO::PARAM_STR);
    $statement->execute();
}
