<?php
require_once __DIR__ . '/../../estadisticaPartido/services/EstadisticaPartidoService.php';
require_once __DIR__ . '/../../partido/services/PartidoService.php';

// opcional: filtrar por partido
$partidoId = $_GET['partido'] ?? '';

$estadisticas = EstadisticaPartidoService::obtenerTodos();

if ($partidoId !== '') {
    $estadisticas = array_filter(
        $estadisticas,
        fn($e) => (int)$e['id_partido'] === (int)$partidoId
    );
}

// para mostrar la jornada
$partidos   = PartidoService::obtenerTodos();
$mapPartido = array_column($partidos, 'jornada', 'id_partido');
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Estadísticas de Partido</h1>

<form action="index.php" method="get" class="row g-3 mb-3">
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

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Partido (Jornada)</th>
      <th>Corners Local</th>
      <th>Corners Visitante</th>
      <th>Faltas Local</th>
      <th>Faltas Visitante</th>
      <th>Ám. Local</th>
      <th>Ám. Visitante</th>
      <th>Roj. Local</th>
      <th>Roj. Visitante</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($estadisticas as $e): ?>
      <?php 
        // aseguro array
        $est = is_array($e) ? $e : (array)$e;
        $jornada = $mapPartido[$est['id_partido']] ?? '—';
      ?>
      <tr>
        <td>Jornada <?= htmlspecialchars($jornada) ?></td>
        <td><?= htmlspecialchars($est['corners_local']      ?? '—') ?></td>
        <td><?= htmlspecialchars($est['corners_visitante']  ?? '—') ?></td>
        <td><?= htmlspecialchars($est['faltas_local']       ?? '—') ?></td>
        <td><?= htmlspecialchars($est['faltas_visitante']   ?? '—') ?></td>
        <td><?= htmlspecialchars($est['tarjetas_amarillas_local']      ?? '—') ?></td>
        <td><?= htmlspecialchars($est['tarjetas_amarillas_visitante']  ?? '—') ?></td>
        <td><?= htmlspecialchars($est['tarjetas_rojas_local']          ?? '—') ?></td>
        <td><?= htmlspecialchars($est['tarjetas_rojas_visitante']      ?? '—') ?></td>
        <td>
          <a href="delete.php?partido=<?= urlencode($est['id_partido']) ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar estadística?');">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
