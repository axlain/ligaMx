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
    public static function totalesPorEquipoInsensitive($nombreEquipo) {
        $nombreEquipo = strtolower($nombreEquipo);

        $totales = EstadisticaPartidoService::obtenerTotalesPorEquipoInsensitive($nombreEquipo);

        header('Content-Type: application/xml');

        $xml = new SimpleXMLElement('<totalesEquipoInsensitive/>');

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

    public static function compararTotalesPorEquipos($equipo1, $equipo2) {
        $equipo1 = strtolower($equipo1);
        $equipo2 = strtolower($equipo2);

        $resultados = EstadisticaPartidoService::compararTotalesPorEquipos($equipo1, $equipo2);

        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement('<comparacionEquipos/>');

        foreach ($resultados as $resultado) {
            $equipoXml = $xml->addChild('equipo');
            $equipoXml->addChild('nombre', htmlspecialchars($resultado['equipo']));
            $equipoXml->addChild('total_corners', htmlspecialchars($resultado['total_corners']));
            $equipoXml->addChild('total_faltas', htmlspecialchars($resultado['total_faltas']));
            $equipoXml->addChild('total_tarjetas_amarillas', htmlspecialchars($resultado['total_tarjetas_amarillas']));
            $equipoXml->addChild('total_tarjetas_rojas', htmlspecialchars($resultado['total_tarjetas_rojas']));
        }

        echo $xml->asXML();
    }

  public static function detalleComparadoEquipos($equipo1, $equipo2) {
    $equipo1 = strtolower($equipo1);
    $equipo2 = strtolower($equipo2);

    $partidos = EstadisticaPartidoService::obtenerTodosPartidosPorEquipos($equipo1, $equipo2);

    header('Content-Type: application/xml');
    $xml = new SimpleXMLElement('<estadisticasEquipo/>');
    $partidosXml = $xml->addChild('partidos');

    foreach ($partidos as $partido) {
        $partidoXml = $partidosXml->addChild('partido');
        foreach ($partido as $key => $value) {
            $partidoXml->addChild($key, htmlspecialchars($value));
        }
    }

    echo $xml->asXML();
}






    
    
}
?>-