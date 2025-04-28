<?php
require_once __DIR__ . '/../controllers/JugadorController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

// Obtener todos los jugadores
if ($request_method === "GET" && $request_uri === '/api/jugador/obtenerTodos') {
    JugadorController::index();
} else if ($request_method === "GET" && preg_match('/\/api\/jugador\/obtenerPorId\/(\d+)/', $request_uri, $matches)) {
    $id = $matches[1];
    JugadorController::show($id);
} else {
    header("HTTP/1.1 404 Not Found");
}
?>
