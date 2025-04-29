<?php
require_once __DIR__ . '/../services/JugadorService.php'; ;

class JugadorController {
    public static function index() {
        $jugadores = JugadorService::obtenerTodos(); 
        header('Content-Type: application/xml');
    
        $xml = new SimpleXMLElement('<jugadores/>');
    
        foreach ($jugadores as $jugador) {
            $jugadorXml = $xml->addChild('jugador');
            foreach ($jugador as $key => $value) {
                $jugadorXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }
    

    public static function show($id){
        $jugador = JugadorService::obtenerPorId($id);
        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<jugador/>');
        foreach ($jugador as $key => $value) {
            $xml->addChild($key, htmlspecialchars($value));
        }

        echo $xml->asXML();
    }

    public static function searchByName($nombre) {
        $jugadores = JugadorService::obtenerPorNombre($nombre);
    
        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement('<jugadores/>');
    
        foreach ($jugadores as $jugador) {
            $jugadorXml = $xml->addChild('jugador');
            foreach ($jugador as $key => $value) {
                $jugadorXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }

    // Buscar jugadores por ID de equipo
    public static function searchByEquipoId($idEquipo) {
        $jugadores = JugadorService::obtenerPorIdEquipo($idEquipo);

        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement('<jugadores/>');

        foreach ($jugadores as $jugador) {
            $jugadorXml = $xml->addChild('jugador');
            foreach ($jugador as $key => $value) {
                $jugadorXml->addChild($key, htmlspecialchars($value));
            }
        }

        echo $xml->asXML();
    }

    // Buscar jugadores por nombre de equipo
    public static function searchByEquipoNombre($nombreEquipo) {
        $jugadores = JugadorService::obtenerPorNombreEquipo($nombreEquipo);

        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement('<jugadores/>');

        foreach ($jugadores as $jugador) {
            $jugadorXml = $xml->addChild('jugador');
            foreach ($jugador as $key => $value) {
                $jugadorXml->addChild($key, htmlspecialchars($value));
            }
        }

        echo $xml->asXML();
    }
    public static function searchByPosicion($posicion) {
        $posicion = trim(urldecode($posicion));     
    
        $jugadores = JugadorService::obtenerPorPosicion($posicion);
    
        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement('<jugadores/>');
    
        foreach ($jugadores as $jugador) {
            $jugadorXml = $xml->addChild('jugador');
            foreach ($jugador as $key => $value) {
                $jugadorXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }

    public static function create() {
        $data = file_get_contents("php://input");
        $xml = simplexml_load_string($data);
    
        $nombre = (string)$xml->nombre;
        $id_equipo = (int)$xml->id_equipo;
        $posicion = (string)$xml->posicion;
        $fecha_nacimiento = (string)$xml->fecha_nacimiento;
    
        if (JugadorService::agregarJugador($nombre, $id_equipo, $posicion, $fecha_nacimiento)) {
            header('HTTP/1.1 201 Created');
            echo "<message>Jugador creado exitosamente</message>";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "<error>Error al crear el jugador</error>";
        }
    }
    

    public static function update() {
        $data = file_get_contents("php://input");
        $xml = simplexml_load_string($data);
    
        // Extraer el ID aquí antes de usarlo
        $id = (int)$xml->id_jugador;
        $nombre = (string)$xml->nombre;
        $id_equipo = (int)$xml->id_equipo;
        $posicion = (string)$xml->posicion;
        $fecha_nacimiento = (string)$xml->fecha_nacimiento;
    
        // Ahora que ya existe $id, puedes usarlo sin warning
        if (JugadorService::actualizarJugador($id, $nombre, $id_equipo, $posicion, $fecha_nacimiento)) {
            header('HTTP/1.1 200 OK');
            echo "<message>Jugador actualizado exitosamente</message>";
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "<error>Error al actualizar el jugador</error>";
        }
    }
    
    
    

    
}
?>-