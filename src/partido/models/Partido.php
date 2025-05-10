<?php
require_once __DIR__ . '/../../config/database.php';

class Partido {
    public static function obtenerTodos() {
        global $conn;
        $sql = "SELECT * FROM partidos";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerPorId($id){
        global $conn;
        $sql = "SELECT * FROM partidos WHERE id_partido = ?";
        $stmt = $conn->prepare($sql);
        //La i indica que el parámetro es un entero
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function obtenerPartidosConEquiposPorJornada($jornada) {
        global $conn;
        $sql = "
            SELECT 
                p.id_partido,
                el.nombre AS equipo_local,
                ev.nombre AS equipo_visitante,
                p.goles_local,
                p.goles_visitante,
                p.fecha,
                p.jornada
            FROM partidos p
            JOIN equipos el ON p.id_equipo_local = el.id_equipo
            JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
            WHERE p.jornada = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $jornada);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public static function obtenerPartidosPorEquipo($nombreEquipo) {
    global $conn;
    $sql = "
        SELECT 
            p.id_partido,
            el.nombre AS equipo_local,
            ev.nombre AS equipo_visitante,
            p.goles_local,
            p.goles_visitante,
            p.fecha,
            p.jornada,
            CASE 
                WHEN LOWER(el.nombre) = LOWER(?) THEN 'Local'
                WHEN LOWER(ev.nombre) = LOWER(?) THEN 'Visitante'
            END AS condicion
        FROM partidos p
        JOIN equipos el ON p.id_equipo_local = el.id_equipo
        JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
        WHERE LOWER(el.nombre) = LOWER(?) OR LOWER(ev.nombre) = LOWER(?)
        ORDER BY p.fecha
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombreEquipo, $nombreEquipo, $nombreEquipo, $nombreEquipo);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
?>
