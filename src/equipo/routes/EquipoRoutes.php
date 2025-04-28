<?php
require_once __DIR__ . '/../controllers/EquipoController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

// Obtener todos los equipo
if ($request_method === "GET" && $request_uri === '/api/ligamx/equipo/obtenerTodos') {
    EquipoController::index();
}else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/equipo\/obtenerPorId\/(\d+)/', $request_uri, $matches)) {
    $id = $matches[1];
    EquipoController::show($id);
}

?>