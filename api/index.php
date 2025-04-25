<?php
// api/index.php
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (strpos($request_uri, '/api/equipo') === 0) {
    include '../src/equipo/index.php';
} else if(strpos($request_uri, '/api/jugador') === 0){
    include '../src/jugador/index.php';
}

else {
    header("HTTP/1.1 404 Not Found");
}
?>