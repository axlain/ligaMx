<?php
require_once __DIR__ . '/../models/Partido.php';

class PartidoService {
    public static function obtenerTodos() {
        return Partido::obtenerTodos();
    }
    public static function obtenerPorId($id) {
        return Partido::obtenerPorId($id);
    }
    public static function obtenerPartidosConEquiposPorJornada($jornada) {
        return Partido::obtenerPartidosConEquiposPorJornada($jornada);
    }
    


}
    


?>