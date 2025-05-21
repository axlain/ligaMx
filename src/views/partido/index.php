<?php
require_once __DIR__ . '/../../partido/services/PartidoService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// filtro por jornada (GET)
$jornada = $_GET['jornada'] ?? '';

// obtengo partidos según filtro
if ($jornada !== '') {
    $partidos = PartidoService::obtenerPartidosConEquiposPorJornada($jornada);
} else {
    $partidos = PartidoService::obtenerTodos();
}

// mapeo para mostrar nombres de equipo
$equipos   = EquipoService::obtenerTodos();
$mapEquipo = array_column($equipos, 'nombre', 'id_equipo');
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Partidos Registrados</h1>

<form action="index.php" method="get" class="row g-3 mb-3">
  <div class="col-md-4">
    <input type="number" name="jornada" class="form-control"
           placeholder="Filtrar por jornada"
           value="<?= htmlspecialchars($jornada) ?>">
  </div>
  <div class="col-md-8">
    <button class="btn btn-primary" type="submit">Filtrar</button>
    <a href="add.php" class="btn btn-success">Agregar Partido</a>
  </div>
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Local</th>
      <th>Visitante</th>
      <th>Fecha</th>
      <th>Resultado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($partidos as $p):
      $local     = $mapEquipo[$p['id_equipo_local']]     ?? '—';
      $visitante = $mapEquipo[$p['id_equipo_visitante']] ?? '—';
      $res       = $p['resultado']
                  ?? (($p['goles_local'] ?? '0')
                      . '-' . ($p['goles_visitante'] ?? '0'));
    ?>
      <tr>
        <td><?= htmlspecialchars($local) ?></td>
        <td><?= htmlspecialchars($visitante) ?></td>
        <td><?= date('d/m/Y H:i', strtotime($p['fecha'])) ?></td>
        <td><?= htmlspecialchars($res) ?></td>
        <td class="table-actions">
          <a href="edit.php?id=<?= urlencode($p['id_partido']) ?>"
             class="btn btn-sm btn-warning">Editar</a>
          <a href="delete.php?id=<?= urlencode($p['id_partido']) ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar partido?');">Eliminar</a>
          <!-- Botón para ir a estadísticas de este partido -->
          <a href="../estadisticaPartido/index.php?partido=<?= urlencode($p['id_partido']) ?>"
             class="btn btn-sm btn-info">Ver Estadísticas</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
