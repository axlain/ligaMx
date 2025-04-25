<?php

$host = 'localhost';
$db_name = 'ligaMx';
$username = 'integracion';
$password = 'password';

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>
