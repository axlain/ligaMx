<?php
require_once __DIR__ . '/../../config/database.php';

class Jugador {
    public static function obtenerTodos() {
        global $conn;
        $sql = "SELECT * FROM jugadores";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerPorId($id){
        global $conn;
        $sql = "SELECT * FROM jugadores WHERE id_jugador = ?";
        $stmt = $conn->prepare($sql);
        //La i indica que el parámetro es un entero
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function obtenerPorNombre($nombre) {
        global $conn;
        $sql = "SELECT * FROM jugadores WHERE nombre LIKE ?";
        $stmt = $conn->prepare($sql);
    
        $param = "%{$nombre}%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
    
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
   // Buscar jugadores por ID del equipo
    public static function obtenerPorIdEquipo($idEquipo) {
        global $conn;
        $sql = "SELECT * FROM jugadores WHERE id_equipo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idEquipo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Buscar jugadores por nombre del equipo
    public static function obtenerPorNombreEquipo($nombreEquipo) {
        global $conn;
        $sql = "SELECT j.* 
                FROM jugadores j
                INNER JOIN equipos e ON j.id_equipo = e.id_equipo
                WHERE e.nombre LIKE ?";
        $stmt = $conn->prepare($sql);

        $param = "%{$nombreEquipo}%"; // búsqueda flexible
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerPorPosicion($posicion) {
        global $conn;
        $sql = "SELECT * FROM jugadores WHERE LOWER(TRIM(posicion)) LIKE LOWER(?)";
        $stmt = $conn->prepare($sql);
    
        $param = "%{$posicion}%"; // sigue permitiendo coincidencias parciales
        $stmt->bind_param("s", $param);
        $stmt->execute();
    
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public static function agregarJugador($nombre, $id_equipo, $posicion, $fecha_nacimiento) {
        global $conn;
        $sql = "INSERT INTO jugadores (nombre, id_equipo, posicion, fecha_nacimiento)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $nombre, $id_equipo, $posicion, $fecha_nacimiento);
        return $stmt->execute();
    }
    

    public static function actualizarJugador($id, $nombre, $id_equipo, $posicion, $fecha_nacimiento) {
        global $conn;
        $sql = "UPDATE jugadores 
                SET nombre = ?, id_equipo = ?, posicion = ?, fecha_nacimiento = ?
                WHERE id_jugador = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissi", $nombre, $id_equipo, $posicion, $fecha_nacimiento, $id);
        return $stmt->execute();
    }

    


}
?>
