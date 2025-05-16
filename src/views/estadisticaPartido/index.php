<?php
require_once __DIR__ . '/../../estadisticaPartido/services/EstadisticaPartidoService.php';
require_once __DIR__ . '/../../partido/services/PartidoService.php';

// (opcional) filtro GET por partido
$partidoId = $_GET['partido'] ?? '';

// obtengo todas las estadísticas
$estadisticas = EstadisticaPartidoService::obtenerTodos();


if ($partidoId !== '') {
     $estadisticas = array_filter(
        $estadisticas,
        fn($e) => (is_array($e) ? $e['id_partido'] : $e->id_partido) == $partidoId
    );
}

// para mostrar la jornada o identificación del partido
$partidos   = PartidoService::obtenerTodos();
$mapPartido = array_column($partidos, 'jornada', 'id_partido');
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Estadísticas de Partido</h1>

<form class="row g-3 mb-3" method="get">
  <div class="col-md-4">
    <select name="partido" class="form-select">
      <option value="">-- Todas las estadísticas --</option>
      <?php foreach($partidos as $p): ?>
        <option value="<?= $p['id_partido'] ?>"
          <?= $partidoId == $p['id_partido'] ? 'selected' : '' ?>>
          Jornada <?= htmlspecialchars($p['jornada']) ?> (ID <?= $p['id_partido'] ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-8">
    <button class="btn btn-primary" type="submit">Filtrar</button>
    <a href="add.php" class="btn btn-success">Agregar Estadística</a>
  </div>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>ID Estadística</th>
      <th>Partido (Jornada)</th>
      <th>Minutos Jugados</th>
      <th>Goles</th>
      <th>Asistencias</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($estadisticas as $eRaw):
      // aseguro array asociativo para acceder sin warnings
      $e = is_array($eRaw) ? $eRaw : (array)$eRaw;
      $idEst       = $e['id_estadistica']     ?? '—';
      $jornada     = $mapPartido[$e['id_partido']]  ?? '—';
      $minutos     = $e['minutos_jugados']    ?? '—';
      $goles       = $e['goles']              ?? '—';
      $asistencias = $e['asistencias']        ?? '—';
    ?>
      <tr>
        <td><?= htmlspecialchars($idEst) ?></td>
        <td>Jornada <?= htmlspecialchars($jornada) ?></td>
        <td><?= htmlspecialchars($minutos) ?></td>
        <td><?= htmlspecialchars($goles) ?></td>
        <td><?= htmlspecialchars($asistencias) ?></td>
        <td>
          <a href="show.php?id=<?= urlencode($idEst) ?>"
             class="btn btn-sm btn-info">Ver</a>
          <a href="edit.php?id=<?= urlencode($idEst) ?>"
             class="btn btn-sm btn-warning">Editar</a>
          <a href="delete.php?id=<?= urlencode($idEst) ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar estadística?');">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
