<?php
require("./inc/headers.php");

session_start();
session_destroy();
unset($_SESSION["username"]);

http_response_code(200);
echo "Olet kirjautunut ulos.";