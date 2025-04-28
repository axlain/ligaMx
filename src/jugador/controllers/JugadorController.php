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

    
}
?>-