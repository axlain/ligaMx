<?php
require_once __DIR__ . '/../models/EstadisticaPartido.php';

class EstadisticaPartidoService {
    public static function obtenerTodos() {
        return EstadisticaPartido::obtenerTodos();
    }
    public static function obtenerPorId($id) {
        return EstadisticaPartido::obtenerPorId($id);
    }
    public static function obtenerTotalesPorEquipoInsensitive($nombreEquipo) {
        return EstadisticaPartido::obtenerTotalesPorEquipoInsensitive($nombreEquipo);
    }
    public static function obtenerDetallePorEquipo($nombreEquipo) {
        return EstadisticaPartido::obtenerDetallePorEquipo($nombreEquipo);
    }
    public static function compararTotalesPorEquipos($equipo1, $equipo2) {
        return EstadisticaPartido::compararTotalesPorEquipos($equipo1, $equipo2);
    }
    public static function obtenerTodosPartidosPorEquipos($equipo1, $equipo2) {
        return EstadisticaPartido::obtenerDetalleComparadoEquipos($equipo1, $equipo2);
    }


}
    


?>