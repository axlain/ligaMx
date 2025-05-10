<?php
require_once __DIR__ . '/../controllers/PartidoController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === "GET" && $request_uri === '/api/ligamx/partido/obtenerTodos') {
    PartidoController::index();
}else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/partido\/obtenerPorId\/(\d+)/', $request_uri, $matches)) {
    $id = $matches[1];
    PartidoController::show($id);
}else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/partido\/obtenerPartidosConEquiposPorJornada\/(\d+)/', $request_uri, $matches)) {
    $jornada = $matches[1];
    PartidoController::indexConEquiposPorJornada($jornada);
}else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/partido\/obtenerPartidosPorEquipo\/([a-zA-Z]+)/', $request_uri, $matches)) {
    $equipo = urldecode($matches[1]);
    PartidoController::partidosPorEquipo($equipo);
}

?>