<?php
require_once __DIR__ . '/../../partido/services/PartidoService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// obtengo arrays
$partidos = PartidoService::obtenerTodos();   // each: ['id_partido','id_equipo_local','id_equipo_visitante','fecha',…]
$equipos  = EquipoService::obtenerTodos();    // each: ['id_equipo','nombre',…]

// mapeo id_equipo → nombre
$mapEquipo = array_column($equipos, 'nombre', 'id_equipo');
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Partidos Registrados</h1>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Local</th>
      <th>Visitante</th>
      <th>Fecha</th>
      <th>Resultado</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($partidos as $p): 
      $local     = $mapEquipo[$p['id_equipo_local']]     ?? '—';
      $visitante = $mapEquipo[$p['id_equipo_visitante']] ?? '—';
      // si hay campo 'resultado' en tu tabla, ajústalo; si usas goles_local/goles_visitante, concaténalos
      $res = $p['resultado'] ?? ($p['goles_local'].'-'.$p['goles_visitante'] ?? '—');
    ?>
      <tr>
        <td><?= htmlspecialchars($local) ?></td>
        <td><?= htmlspecialchars($visitante) ?></td>
        <td><?= date('d/m/Y H:i', strtotime($p['fecha'])) ?></td>
        <td><?= htmlspecialchars($res) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; 

?>
