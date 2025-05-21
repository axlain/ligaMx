<?php
require_once __DIR__ . '/../services/UsuarioService.php'; ;

class UsuarioController {
    public static function index() {
        $usuarios = UsuarioService::obtenerTodos(); 
        header('Content-Type: application/xml');
    
        $xml = new SimpleXMLElement('<usuarios/>');
    
        foreach ($usuarios as $usuario) {
            $usuarioXml = $xml->addChild('usuario');
            foreach ($usuario as $key => $value) {
                $usuarioXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }
    public static function crearUsuario() {
        header('Content-Type: application/xml');

        $data = file_get_contents("php://input");
        $xml = simplexml_load_string($data);

        if (!$xml) {
            header("HTTP/1.1 400 Bad Request");
            echo "<error>XML inválido</error>";
            return;
        }

        $nombre = (string)$xml->nombre ?? null;
        $email = (string)$xml->email ?? null;
        $contraseña = (string)$xml->contraseña ?? null;
        $fechaNacimiento = (string)$xml->fecha_nacimiento ?? null;

        if (!$nombre || !$email || !$contraseña || !$fechaNacimiento) {
            header("HTTP/1.1 400 Bad Request");
            echo "<error>Faltan datos requeridos</error>";
            return;
        }

        try {
            UsuarioService::crearUsuario($nombre, $email, $contraseña, $fechaNacimiento);
            header("HTTP/1.1 200 Created");
            echo "<message>Usuario registrado correctamente</message>";
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo "<error>" . htmlspecialchars($e->getMessage()) . "</error>";
        }
    }
    
    public static function guardarPreferenciasEquipos() {
        header('Content-Type: application/json');

        $data = file_get_contents("php://input");
        $xml = simplexml_load_string($data);

        if (!$xml || !isset($xml->id_usuario) || !isset($xml->equipos->equipo)) {
            http_response_code(400);
            echo json_encode(['error' => 'XML mal formado o datos faltantes']);
            return;
        }

        $idUsuario = (int) $xml->id_usuario;
        $equipos = [];

        foreach ($xml->equipos->equipo as $equipo) {
            $equipos[] = (string) $equipo;
        }

        try {
            UsuarioService::guardarPreferenciasEquipos($idUsuario, $equipos);
            http_response_code(200);
            echo json_encode(['mensaje' => 'Preferencias guardadas correctamente']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public static function eliminarPreferenciasUsuario() {
        header('Content-Type: application/json');

        $data = file_get_contents("php://input");
        $xml = simplexml_load_string($data);

        if (!$xml || !isset($xml->id_usuario)) {
            http_response_code(400);
            echo json_encode(['error' => 'XML mal formado o falta id_usuario']);
            return;
        }

        $idUsuario = (int) $xml->id_usuario;

        try {
            UsuarioService::eliminarPreferenciasUsuario($idUsuario);
            http_response_code(200);
            echo json_encode(['mensaje' => 'Preferencias eliminadas correctamente']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}
?>-