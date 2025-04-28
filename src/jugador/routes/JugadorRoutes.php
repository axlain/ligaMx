<?php
require_once __DIR__ . '/../controllers/JugadorController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

// Obtener todos los jugadores
if ($request_method === "GET" && $request_uri === '/api/ligamx/jugador/obtenerTodos') {
    JugadorController::index();
} else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/jugador\/obtenerPorId\/(\d+)/', $request_uri, $matches)) {
    $id = $matches[1];
    JugadorController::show($id);
}else if ($request_method === "GET" && preg_match('#^/api/ligamx/jugador/cd /([^/]+)$#', $request_uri, $matches)) {
    $nombre = urldecode($matches[1]);
    JugadorController::searchByName($nombre);
}else if ($request_method === "GET" && preg_match('#^/api/ligamx/jugador/buscarPorEquipoId/(\d+)$#', $request_uri, $matches)) {
    $idEquipo = $matches[1];
    JugadorController::searchByEquipoId($idEquipo);
}else if ($request_method === "GET" && preg_match('#^/api/ligamx/jugador/buscarPorEquipoNombre/([^/]+)$#', $request_uri, $matches)) {
    $nombreEquipo = urldecode($matches[1]);
    JugadorController::searchByEquipoNombre($nombreEquipo);
}else if ($request_method === "GET" && preg_match('#^/api/ligamx/jugador/buscarPorPosicion/([^/]+)$#', $request_uri, $matches)) {
    $posicion = urldecode($matches[1]);
    JugadorController::searchByPosicion($posicion);
}



else {
    header("HTTP/1.1 404 Not Found");
}
?>
