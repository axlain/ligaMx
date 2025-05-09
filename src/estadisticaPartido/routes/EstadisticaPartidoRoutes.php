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
else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/totalesInsensitive\/([a-zA-Z]+)/', $request_uri, $matches)) {
    $equipo = $matches[1];
    EstadisticaPartidoController::totalesPorEquipoInsensitive(urldecode($equipo));
}

else if ($request_method === "GET" && preg_match('/\/api\/ligamx\/estadisticapartido\/detallePorEquipo\/([a-zA-Z]+)/', $request_uri, $matches)) {
    $equipo = $matches[1];
    EstadisticaPartidoController::detallePorEquipo(urldecode($equipo));
}


?>