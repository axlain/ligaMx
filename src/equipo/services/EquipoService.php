<?php
require_once __DIR__ . '/../models/Equipo.php';

class EquipoService {
    public static function obtenerTodos() {
        return Equipo::obtenerTodos();
    }


}
    


?>