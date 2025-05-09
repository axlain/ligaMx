<?php
require_once __DIR__ . '/../../config/database.php';

class EstadisticaPartido {
    public static function obtenerTodos() {
        global $conn;
        $sql = "SELECT * FROM estadisticas_partido";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerPorId($id){
        global $conn;
        $sql = "SELECT * FROM estadisticas_partido WHERE id_partido = ?";
        $stmt = $conn->prepare($sql);
        //La i indica que el parámetro es un entero
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function obtenerTotalesPorEquipoInsensitive($nombreEquipo) {
        global $conn;
        $sql = "
            SELECT
                SUM(
                    CASE WHEN LOWER(el.nombre) = LOWER(?) THEN ep.corners_local
                        WHEN LOWER(ev.nombre) = LOWER(?) THEN ep.corners_visitante
                    END
                ) AS total_corners,
                SUM(
                    CASE WHEN LOWER(el.nombre) = LOWER(?) THEN ep.faltas_local
                        WHEN LOWER(ev.nombre) = LOWER(?) THEN ep.faltas_visitante
                    END
                ) AS total_faltas,
                SUM(
                    CASE WHEN LOWER(el.nombre) = LOWER(?) THEN ep.tarjetas_amarillas_local
                        WHEN LOWER(ev.nombre) = LOWER(?) THEN ep.tarjetas_amarillas_visitante
                    END
                ) AS total_tarjetas_amarillas,
                SUM(
                    CASE WHEN LOWER(el.nombre) = LOWER(?) THEN ep.tarjetas_rojas_local
                        WHEN LOWER(ev.nombre) = LOWER(?) THEN ep.tarjetas_rojas_visitante
                    END
                ) AS total_tarjetas_rojas
            FROM estadisticas_partido ep
            JOIN partidos p ON ep.id_partido = p.id_partido
            JOIN equipos el ON p.id_equipo_local = el.id_equipo
            JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
            WHERE LOWER(el.nombre) = LOWER(?) OR LOWER(ev.nombre) = LOWER(?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss",
            $nombreEquipo, $nombreEquipo, // corners
            $nombreEquipo, $nombreEquipo, // faltas
            $nombreEquipo, $nombreEquipo, // amarillas
            $nombreEquipo, $nombreEquipo, // rojas
            $nombreEquipo, $nombreEquipo  // WHERE
        );
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    
   public static function obtenerDetallePorEquipo($nombreEquipo) {
    global $conn;
    $sql = "
        SELECT
            p.id_partido,
            p.fecha,
            CASE 
                WHEN LOWER(el.nombre) = LOWER(?) THEN 'Local'
                WHEN LOWER(ev.nombre) = LOWER(?) THEN 'Visitante'
            END AS condicion,
            CASE 
                WHEN LOWER(el.nombre) = LOWER(?) THEN ep.corners_local
                ELSE ep.corners_visitante
            END AS corners,
            CASE 
                WHEN LOWER(el.nombre) = LOWER(?) THEN ep.faltas_local
                ELSE ep.faltas_visitante
            END AS faltas,
            CASE 
                WHEN LOWER(el.nombre) = LOWER(?) THEN ep.tarjetas_amarillas_local
                ELSE ep.tarjetas_amarillas_visitante
            END AS tarjetas_amarillas,
            CASE 
                WHEN LOWER(el.nombre) = LOWER(?) THEN ep.tarjetas_rojas_local
                ELSE ep.tarjetas_rojas_visitante
            END AS tarjetas_rojas
        FROM estadisticas_partido ep
        JOIN partidos p ON ep.id_partido = p.id_partido
        JOIN equipos el ON p.id_equipo_local = el.id_equipo
        JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
        WHERE LOWER(el.nombre) = LOWER(?) OR LOWER(ev.nombre) = LOWER(?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", 
            $nombreEquipo, $nombreEquipo, $nombreEquipo, 
            $nombreEquipo, $nombreEquipo, $nombreEquipo, 
            $nombreEquipo, $nombreEquipo
        );

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


}
?>
