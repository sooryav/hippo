<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'atulatul');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'hippo');


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

   die();
}
else
{
   echo "Connected successfully: " . $mysqli->host_info . "<br>";
}

?>
