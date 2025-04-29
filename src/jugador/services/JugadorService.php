<?php
require_once __DIR__ . '/../models/Jugador.php';

class JugadorService {
    public static function obtenerTodos() {
        return Jugador::obtenerTodos();
    }

    public static function obtenerPorId($id) {
        return Jugador::obtenerPorId($id);
    }

    public static function obtenerPorNombre($nombre) {
        return Jugador::obtenerPorNombre($nombre);
    }
    
    public static function obtenerPorIdEquipo($idEquipo) {
        return Jugador::obtenerPorIdEquipo($idEquipo);
    }
    
    public static function obtenerPorNombreEquipo($nombreEquipo) {
        return Jugador::obtenerPorNombreEquipo($nombreEquipo);
    }
    public static function obtenerPorPosicion($posicion) {
        return Jugador::obtenerPorPosicion($posicion);
    }
    public static function agregarJugador($nombre, $id_equipo, $posicion, $fecha_nacimiento) {
        return Jugador::agregarJugador($nombre, $id_equipo, $posicion, $fecha_nacimiento);
    } 
    public static function actualizarJugador($id, $nombre, $id_equipo, $posicion, $fecha_nacimiento) {
        return Jugador::actualizarJugador($id, $nombre, $id_equipo, $posicion, $fecha_nacimiento);
    }
    
    
}
?>
