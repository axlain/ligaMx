<?php
require_once __DIR__ . '/../models/EstadisticaPartido.php';

class EstadisticaPartidoService {
    public static function obtenerTodos() {
        return EstadisticaPartido::obtenerTodos();
    }
    public static function obtenerPorId($id) {
        return EstadisticaPartido::obtenerPorId($id);
    }
    public static function obtenerTotalesPorEquipo($nombreEquipo) {
        return EstadisticaPartido::obtenerTotalesPorEquipo($nombreEquipo);
    }
    
    public static function obtenerDetallePorEquipo($nombreEquipo) {
        return EstadisticaPartido::obtenerDetallePorEquipo($nombreEquipo);
    }
    

}
    


?>