<?php
require("./dbConnection.php");

// palauttaa kaikki kategoriat tai tietyn.
function selectCategories($productCategory)
{

    $db = createSqliteConnection("./bikestore.db");
    if ($productCategory === "all") {
        $sql = "SELECT * FROM tuoteryhma";
        $statement = $db->prepare($sql);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sql = "SELECT * FROM tuoteryhma WHERE trnimi=:category";
        $statement = $db->prepare($sql);
        $statement->bindParam(':category', $productCategory, PDO::PARAM_STR);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    return $categories;
}
// Palauttaa tuotetiedot id:n perusteella
function getProduct($productId)
{
    $db = createSqliteConnection("./bikestore.db");

    $sql = "SELECT * FROM tuote WHERE tuoteid = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $productId);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
// Palauttaa tuotteet kategorian mukaan.
function productsByCategory($productCategory)
{

    $db = createSqliteConnection("./bikestore.db");

    $sql = "SELECT * FROM tuote INNER JOIN tuoteryhma ON tuote.trid=tuoteryhma.trid WHERE trnimi=:category";
    $statement = $db->prepare($sql);
    $statement->bindParam(':category', $productCategory, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
// Lisää uuden kategorian
function addCategory($productCategory)
{
    $db = createSqliteConnection("./bikestore.db");

    $sql = "INSERT INTO tuoteryhma (trnimi) VALUES(?)";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $productCategory, PDO::PARAM_STR);
    $statement->execute();
}
// Lisää uuden tuotteen
function addProduct($productName, $productPrice, $productTrId, $productImg, $productCount, $productSize)
{

    $db = createSqliteConnection("./bikestore.db");

    $sql = "INSERT INTO tuote (nimi,hinta,trid,kuva,saldo,koko) VALUES(?,?,?,?,?,?)";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $productName, PDO::PARAM_STR);
    $statement->bindParam(2, $productPrice, PDO::PARAM_INT);
    $statement->bindParam(3, $productTrId, PDO::PARAM_INT);
    $statement->bindParam(4, $productImg, PDO::PARAM_STR);
    $statement->bindParam(5, $productCount, PDO::PARAM_INT);
    $statement->bindParam(6, $productSize, PDO::PARAM_STR);
    $statement->execute();
}
//Käyttäjän Id emailin perusteella palautetaan
function userId($userEmail, $db)
{


    $sql = "SELECT id FROM asiakas WHERE sposti=:sposti";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $userEmail);
    $statement->execute();
    // Pitää sisällään ID:n joka on haettu spostillta mikä on sessiossa.
    return $statement->fetchColumn();
}
//Uusi tilaus ja palauttaa viimeisimmän id
function newOrder($id, $orderDate, $orderTotal, $db)
{

    $orderText = "Tilaus on vastaanotettu.";

    $sql = "INSERT INTO tilaus (id,tila,tilauspvm,summa) VALUES (?,?,?,?)";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $id, PDO::PARAM_INT);
    $statement->bindParam(2, $orderText, PDO::PARAM_STR);
    $statement->bindParam(3, $orderDate);
    $statement->bindParam(4, $orderTotal, PDO::PARAM_INT);
    $statement->execute();
    return $db->lastInsertId();
}


//Tilausriville uudet rivit tuotteiden määrän mukaan
function addNewOrderLines($order, $lastId, $db)
{

    $row = 0;

    foreach ($order->tuotteet as $product) {
        $row += 1;
        $productId = filter_var($product->tuoteId, FILTER_SANITIZE_NUMBER_INT);
        $productCount = filter_var($product->kpl, FILTER_SANITIZE_NUMBER_INT);

        $sql = "INSERT INTO tilausrivi (tilausnro,rivinro,tuoteid,kpl) VALUES (?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $lastId, PDO::PARAM_INT);
        $statement->bindParam(2, $row, PDO::PARAM_INT);
        $statement->bindParam(3, $productId, PDO::PARAM_INT);
        $statement->bindParam(4, $productCount, PDO::PARAM_INT);
        $statement->execute();
    }
}
// Päivitetään tilauksen tila
function orderManagement($orderState, $orderNumber, $db)
{
    $sql = "UPDATE tilaus SET tila=? WHERE tilausnro=?";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $orderState, PDO::PARAM_STR);
    $statement->bindParam(2, $orderNumber, PDO::PARAM_INT);
    $statement->execute();
}
