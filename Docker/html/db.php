<?php

function getMySQLiConnection() {
    $servername = 'mariadb';
    $username = 'root';
    $password = 'admin';
    $database = 'lamp';

    $mysqli = new mysqli($servername, $username, $password, $database);

    return $mysqli;
}

?>