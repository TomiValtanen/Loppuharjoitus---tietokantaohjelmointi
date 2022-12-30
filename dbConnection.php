<?php
function createSqliteConnection($filename){
    try{
        $dbcon = new PDO("sqlite:".$filename);
        return $dbcon;
    }catch(PDOException $e){
        http_response_code(505);
        echo "Service is currently unavailable.";
    }

    return null;
}
