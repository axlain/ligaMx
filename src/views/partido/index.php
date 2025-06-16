<?php
require_once __DIR__ . '/../../partido/services/PartidoService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// filtros (GET)
$jornada  = $_GET['jornada'] ?? '';
$idEquipo = $_GET['equipo']  ?? '';

// obtengo equipos para el filtro
$equipos = EquipoService::obtenerTodos();

// mapeo para nombres si hiciera falta
$mapEquipo = array_column($equipos, 'nombre', 'id_equipo');

// aplico filtros: equipo > jornada > todos
if ($idEquipo !== '') {
    // Obtener el nombre del equipo seleccionado
    $nombreEquipo = $mapEquipo[$idEquipo] ?? '';
    // Traigo todos los partidos de ese equipo por nombre
    $partidos = PartidoService::obtenerPartidosPorEquipo($nombreEquipo);
    // Si además hay jornada, filtro el array resultante
    if ($jornada !== '') {
        $partidos = array_filter(
            $partidos,
            fn($p) => (string)($p['jornada'] ?? '') === (string)$jornada
        );
    }
} elseif ($jornada !== '') {
    $partidos = PartidoService::obtenerPartidosConEquiposPorJornada($jornada);
} else {
    $partidos = PartidoService::obtenerTodos();
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Partidos Registrados</h1>

<form action="index.php" method="get" class="row g-3 mb-3">
  <div class="col-md-3">
    <input type="number" name="jornada" class="form-control"
           placeholder="Filtrar por jornada"
           value="<?= htmlspecialchars($jornada) ?>">
  </div>
  <div class="col-md-4">
    <select name="equipo" class="form-select">
      <option value="">-- Filtrar por equipo --</option>
      <?php foreach ($equipos as $e): ?>
        <option value="<?= $e['id_equipo'] ?>"
          <?= ($idEquipo == $e['id_equipo']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($e['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-5">
    <button class="btn btn-primary" type="submit">Filtrar</button>
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
    <?php if (empty($partidos)): ?>
      <tr><td colspan="5" class="text-center">No se encontraron partidos.</td></tr>
    <?php else: ?>
      <?php foreach ($partidos as $p):
          // 1) Servicio jornada: ya trae 'local'/'visitante'
          if (isset($p['local'], $p['visitante'])) {
              $local     = $p['local'];
              $visitante = $p['visitante'];
          }
          // 2) Servicio equipo: suele traer 'equipo_local'/'equipo_visitante'
          elseif (isset($p['equipo_local'], $p['equipo_visitante'])) {
              $local     = $p['equipo_local'];
              $visitante = $p['equipo_visitante'];
          }
          // 3) Raw IDs: mapeamos
          elseif (isset($p['id_equipo_local'], $p['id_equipo_visitante'])) {
              $local     = $mapEquipo[$p['id_equipo_local']]     ?? '—';
              $visitante = $mapEquipo[$p['id_equipo_visitante']] ?? '—';
          } else {
              $local = $visitante = '—';
          }

          $res = $p['resultado']
                ?? (($p['goles_local'] ?? '0') . '-' . ($p['goles_visitante'] ?? '0'));
      ?>
        <tr>
          <td><?= htmlspecialchars($local) ?></td>
          <td><?= htmlspecialchars($visitante) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($p['fecha'])) ?></td>
          <td><?= htmlspecialchars($res) ?></td>
          <td class="table-actions">
            <a href="../estadisticaPartido/index.php?partido=<?= urlencode($p['id_partido']) ?>"
               class="btn btn-sm btn-info">Ver Estadísticas</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
