<?php
require_once __DIR__ . '/../services/PartidoService.php'; ;

class PartidoController {
    public static function index() {
        $partidos = PartidoService::obtenerTodos(); 
        header('Content-Type: application/xml');
    
        $xml = new SimpleXMLElement('<partidos/>');
    
        foreach ($partidos as $partido) {
            $partidoXml = $xml->addChild('partido');
            foreach ($partido as $key => $value) {
                $partidoXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }
    

    public static function show($id){
        $partido = PartidoService::obtenerPorId($id);
        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<partido/>');
        foreach ($partido as $key => $value) {
            $xml->addChild($key, htmlspecialchars($value));
        }

        echo $xml->asXML();
    }

    public static function indexConEquiposPorJornada($jornada) {
        $partidos = PartidoService::obtenerPartidosConEquiposPorJornada($jornada);
        header('Content-Type: application/xml');
    
        $xml = new SimpleXMLElement('<partidosJornada/>');
    
        foreach ($partidos as $partido) {
            $partidoXml = $xml->addChild('partido');
            foreach ($partido as $key => $value) {
                $partidoXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }
    
    
}
?>-