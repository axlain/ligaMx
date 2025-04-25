<?php
require_once __DIR__ . '/../services/EquipoService.php'; ;

class EquipoController {
    public static function index() {
        $equipos = EquipoService::obtenerTodos(); 
        header('Content-Type: application/xml');
    
        $xml = new SimpleXMLElement('<equipos/>');
    
        foreach ($equipos as $equipo) {
            $equipoXml = $xml->addChild('equipo');
            foreach ($equipo as $key => $value) {
                $equipoXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }
    

    public static function show($id){
        $equipo = EquipoService::obtenerPorId($id);
        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<equipo/>');
        foreach ($equipo as $key => $value) {
            $xml->addChild($key, htmlspecialchars($value));
        }

        echo $xml->asXML();
    }

    
}
?>-