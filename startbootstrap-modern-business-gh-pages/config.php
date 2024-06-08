<?php

define('DB_SERVER', "140.122.184.129:3310");
define('DB_USERNAME', 'team12');
define('DB_PASSWORD', 'SM(tFcLC*Ma0(N(E');
define('DB_DATABASE', 'team12');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>
