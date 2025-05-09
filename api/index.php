<?php
// api/index.php
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (strpos($request_uri, '/api/ligamx') === 0) {
    include '../src/equipo/index.php';
    include '../src/jugador/index.php';
    include '../src/partido/index.php';
    include '../src/estadisticaPartido/index.php';
} else {
    header("HTTP/1.1 404 Not Found");
}
?>
