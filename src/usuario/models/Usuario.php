<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    public static function obtenerTodos() {
        global $conn;
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public static function crearUsuario($nombre, $email, $contraseñaHashed, $fechaNacimiento) {
        global $conn;
        $sql = "INSERT INTO usuarios (nombre, email, contraseña, fecha_registro, fecha_nacimiento) 
                VALUES (?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("ssss", $nombre, $email, $contraseñaHashed, $fechaNacimiento);
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar usuario: " . $stmt->error);
        }
        $stmt->close();
        return true;
    }
    public static function emailExiste($email) {
        global $conn;
        $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Error preparando consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    // Obtener id_equipo por nombre
    public static function obtenerIdEquipoPorNombre($nombreEquipo) {
        global $conn;
        $sql = "SELECT id_equipo FROM equipos WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando consulta equipos: " . $conn->error);
        }
        $stmt->bind_param("s", $nombreEquipo);
        $stmt->execute();
        $result = $stmt->get_result();
        $idEquipo = null;
        if ($row = $result->fetch_assoc()) {
            $idEquipo = $row['id_equipo'];
        }
        $stmt->close();
        return $idEquipo;
    }

    // Insertar preferencia usuario-equipo (ignorar duplicados)
    public static function agregarPreferencia($idUsuario, $idEquipo) {
        global $conn;
        $sql = "INSERT IGNORE INTO preferencias_usuarios (id_usuario, id_equipo) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando inserción preferencias: " . $conn->error);
        }
        $stmt->bind_param("ii", $idUsuario, $idEquipo);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    // Eliminar preferencias anteriores de un usuario
    public static function eliminarPreferenciasUsuario($idUsuario) {
        global $conn;
        $sql = "DELETE FROM preferencias_usuarios WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando eliminación preferencias: " . $conn->error);
        }
        $stmt->bind_param("i", $idUsuario);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }
}
?>
