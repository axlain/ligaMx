<?php
require_once __DIR__ . '/../services/EstadisticaPartidoService.php'; ;

class EstadisticaPartidoController {
    public static function index() {
        $estadisticaPartidos = EstadisticaPartidoService::obtenerTodos(); 
        header('Content-Type: application/xml');
    
        $xml = new SimpleXMLElement('<estadisticaPartido/>');
    
        foreach ($estadisticaPartidos as $estadisticaPartido) {
            $estadisticaPartidoXml = $xml->addChild('estadisticaPartido');
            foreach ($estadisticaPartido as $key => $value) {
                $estadisticaPartidoXml->addChild($key, htmlspecialchars($value));
            }
        }
    
        echo $xml->asXML();
    }
    

    public static function show($id){
        $estadisticaPartido = EstadisticaPartidoService::obtenerPorId($id);
        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<estadisticaPartido/>');
        foreach ($estadisticaPartido as $key => $value) {
            $xml->addChild($key, htmlspecialchars($value));
        }

        echo $xml->asXML();
    }


    // FUNCIÓN PARA TOTALES (sumadas local + visitante)
    public static function totalesPorEquipo($nombreEquipo) {
        $nombreEquipo = strtolower($nombreEquipo);

        $totales = EstadisticaPartidoService::obtenerTotalesPorEquipo($nombreEquipo);

        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<totalesEquipo/>');

        foreach ($totales as $key => $value) {
            $xml->addChild($key, htmlspecialchars($value));
        }

        echo $xml->asXML();
    }

    public static function detallePorEquipo($nombreEquipo) {

        $nombreEquipo = strtolower($nombreEquipo);

        $detalles = EstadisticaPartidoService::obtenerDetallePorEquipo($nombreEquipo);


        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<estadisticasEquipo/>');
        $partidosXml = $xml->addChild('partidos');

        foreach ($detalles as $detalle) {
            $partidoXml = $partidosXml->addChild('partido');
            foreach ($detalle as $key => $value) {
                $partidoXml->addChild($key, htmlspecialchars($value));
            }
        }

        echo $xml->asXML();
    }
    
    
}
?>-