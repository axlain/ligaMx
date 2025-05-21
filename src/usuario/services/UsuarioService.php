<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioService {
    public static function obtenerTodos() {
        return Usuario::obtenerTodos();
    }
    public static function crearUsuario($nombre, $email, $contraseña, $fechaNacimiento) {
        if (Usuario::emailExiste($email)) {
            throw new Exception("El email ya está registrado");
        }
        return Usuario::crearUsuario($nombre, $email, $contraseña, $fechaNacimiento);
    }
    public static function guardarPreferenciasEquipos($idUsuario, $nombresEquipos) {
        if (!is_array($nombresEquipos)) {
            throw new Exception("Los equipos deben ser un arreglo");
        }

        Usuario::eliminarPreferenciasUsuario($idUsuario);

        foreach ($nombresEquipos as $nombreEquipo) {
            $idEquipo = Usuario::obtenerIdEquipoPorNombre($nombreEquipo);
            if (!$idEquipo) {
                throw new Exception("El equipo '$nombreEquipo' no existe");
            }
            Usuario::agregarPreferencia($idUsuario, $idEquipo);
        }

        return true;
    }

    public static function eliminarPreferenciasUsuario($idUsuario) {
        return Usuario::eliminarPreferenciasUsuario($idUsuario);
    }
   


}
    


?>