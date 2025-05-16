<?php
require_once __DIR__ . '/../controllers/EstadisticaPartidoController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === "GET" && $request_uri === '/api/ligamx/estadisticapartido/obtenerTodos') {
    EstadisticaPartidoController::index();
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/obtenerPorId\/(\d+)/', $request_uri, $matches)) {
    $id = $matches[1];
    EstadisticaPartidoController::show($id);
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/totalesInsensitive\/(.+)/', $request_uri, $matches)) {
    $equipo = urldecode($matches[1]);
    EstadisticaPartidoController::totalesPorEquipoInsensitive($equipo);
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/detallePorEquipo\/(.+)/', $request_uri, $matches)) {
    $equipo = urldecode($matches[1]);
    EstadisticaPartidoController::detallePorEquipo($equipo);
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/compararTotales\/(.+)\/(.+)/', $request_uri, $matches)) {
    $equipo1 = urldecode($matches[1]);
    $equipo2 = urldecode($matches[2]);
    EstadisticaPartidoController::compararTotalesPorEquipos($equipo1, $equipo2);
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/detalleComparadoEquipos\/(.+)\/(.+)/', $request_uri, $matches)) {
    $equipo1 = urldecode($matches[1]);
    $equipo2 = urldecode($matches[2]);
    EstadisticaPartidoController::detalleComparadoEquipos($equipo1, $equipo2);
}
?>
