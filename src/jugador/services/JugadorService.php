<?php
require_once __DIR__ . '/../models/Jugador.php';

class JugadorService {
    public static function obtenerTodos() {
        return Jugador::obtenerTodos();
    }

    public static function obtenerPorId($id) {
        return Jugador::obtenerPorId($id);
    }
}
?>
