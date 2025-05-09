<?php
require_once __DIR__ . '/../controllers/EstadisticaPartidoController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === "GET" && $request_uri === '/api/ligamx/estadisticapartido/obtenerTodos') {
    EstadisticaPartidoController::index();
}else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/obtenerPorId\/(\d+)/', $request_uri, $matches)) {
    $id = $matches[1];
    EstadisticaPartidoController::show($id);
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticaPartido\/totales\/(.+)/', $request_uri, $matches)) {
    $nombreEquipo = urldecode($matches[1]);
    EstadisticaPartidoController::totalesPorEquipo($nombreEquipo);
}
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticaPartido\/detalle\/(.+)/', $request_uri, $matches)) {
    $nombreEquipo = urldecode($matches[1]);
    EstadisticaPartidoController::detallePorEquipo($nombreEquipo);
}


?>