<?php

$host = 'localhost';
$db_name = 'ligaMx';
$username = 'root';
$password = 'kaway123';

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>
