<?php
require("./inc/headers.php");
session_start();
require("./userControl.php");


if (!isset($_POST["userTag"]) || !isset($_POST["userPw"])) {
    http_response_code(401);
    echo "Sähköposti tai salasana on virheellinen.";
    return;
}

if (isset($_SESSION['username']) && $_SESSION['username'] === $_POST["userTag"]) {
    http_response_code(200);
    echo $_SESSION['username'] . " Olet jo kirjautunut sisään";
    return;
}


$userEmail = filter_var($_POST["userTag"], FILTER_SANITIZE_EMAIL);
try {

    $hashPw = password($userEmail);

    $verifyUser;

    if (isset($hashPw)) {
        $verifyUser = password_verify($_POST["userPw"], $hashPw) ? $userEmail : null;
    }

    if ($verifyUser) {
        $_SESSION["username"] = $verifyUser;
        http_response_code(200);
        echo $verifyUser . " Kirjauduit sisään!";
    } else {
        http_response_code(401);
        echo "Väärä sähköposti tai salasana.";
    }
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
