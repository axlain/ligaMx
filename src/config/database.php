<?php

$host = 'localhost';
$db_name = 'ligamx';
$username = 'ligamx';
$password = 'password';

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>
