<?php
require_once __DIR__ . '/../../estadisticaPartido/services/EstadisticaPartidoService.php';
require_once __DIR__ . '/../../partido/services/PartidoService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// filtros GET
$partidoId   = $_GET['partido'] ?? '';
$equipoId    = $_GET['equipo']  ?? '';

// obtengo lista de equipos para el select
$equipos = EquipoService::obtenerTodos();

// si se filtró por equipo, obtengo su nombre y detallo por equipo
$detallePorEquipo = null;
if ($equipoId !== '') {
    // mapeo ID a nombre
    $mapEquipo = array_column($equipos, 'nombre', 'id_equipo');
    $nombreEquipo = $mapEquipo[$equipoId] ?? '';
    if ($nombreEquipo !== '') {
        $detallePorEquipo = EstadisticaPartidoService::obtenerDetallePorEquipo($nombreEquipo);
        $todosPartidos = PartidoService::obtenerTodos();
        $mapPartido = array_column($todosPartidos, 'jornada', 'id_partido');
    }
}

// si no hay filtro por equipo, uso el array general
if ($detallePorEquipo === null) {
    // opcional: filtrar por partido
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
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Estadísticas de Partido</h1>

<form action="index.php" method="get" class="row g-3 mb-3">
  <div class="col-md-3">
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
  <div class="col-md-3">
    <select name="equipo" class="form-select">
      <option value="">-- Filtrar por equipo --</option>
      <?php foreach($equipos as $eq): ?>
        <option value="<?= is_array($eq) ? $eq['id_equipo'] : $eq->id_equipo ?>"
          <?= $equipoId == (is_array($eq) ? $eq['id_equipo'] : $eq->id_equipo) ? 'selected' : '' ?>>
          <?= htmlspecialchars(is_array($eq) ? $eq['nombre'] : $eq->nombre) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-6">
    <button class="btn btn-primary" type="submit">Filtrar</button>
    <a href="comparar.php" class="btn btn-outline-secondary">Comparar totales por equipo</a>
  </div>
</form>

<?php if ($detallePorEquipo !== null): ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Partido (ID)</th>
        <th>Jornada</th>
        <th>Fecha</th>
        <th>Condición</th>
        <th>Corners</th>
        <th>Faltas</th>
        <th>Ám. Amarillas</th>
        <th>Roj. Rojas</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($detallePorEquipo as $d): ?>
        <?php 
          // obtengo jornada usando el mapPartido
          $j = $mapPartido[$d['id_partido']] ?? '—';
        ?>
        <tr>
          <td><?= htmlspecialchars($d['id_partido']) ?></td>
          <td><?= htmlspecialchars($j) ?></td>
          <td><?= htmlspecialchars($d['fecha']) ?></td>
          <td><?= htmlspecialchars($d['condicion']) ?></td>
          <td><?= htmlspecialchars($d['corners']) ?></td>
          <td><?= htmlspecialchars($d['faltas']) ?></td>
          <td><?= htmlspecialchars($d['tarjetas_amarillas']) ?></td>
          <td><?= htmlspecialchars($d['tarjetas_rojas']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
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
      </tr>
    </thead>
    <tbody>
      <?php foreach($estadisticas as $e): ?>
        <?php 
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
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
