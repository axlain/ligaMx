<?php
require_once __DIR__ . '/../controllers/UsuarioController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === "GET" && $request_uri === '/api/ligamx/usuario/obtenerTodos') {
    UsuarioController::index();
}
elseif ($request_method === 'POST' && $request_uri === '/api/ligamx/usuario/crear') {
    UsuarioController::crearUsuario();
} elseif ($request_method === 'POST' && $request_uri === '/api/ligamx/usuario/preferencias') {
    UsuarioController::guardarPreferenciasEquipos();
} 
?>