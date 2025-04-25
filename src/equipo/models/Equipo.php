<?php
require_once __DIR__ . '/../../config/database.php';

class Equipo {
    public static function obtenerTodos() {
        global $conn;
        $sql = "SELECT * FROM equipos";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerPorId($id){
        global $conn;
        $sql = "SELECT * FROM equipos WHERE id_equipo = ?";
        $stmt = $conn->prepare($sql);
        //La i indica que el parámetro es un entero
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

}
?>
