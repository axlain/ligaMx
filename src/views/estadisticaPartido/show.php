<?php
require_once __DIR__ . '/../../estadisticaPartido/services/EstadisticaPartidoService.php';
require_once __DIR__ . '/../../partido/services/PartidoService.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// obtengo estadística y partido para mostrar datos
$eRaw      = EstadisticaPartidoService::obtenerPorId($id);
if (!$eRaw) {
    header('Location: index.php');
    exit;
}
$est       = is_array($eRaw) ? $eRaw : (array)$eRaw;

$partido   = PartidoService::obtenerPorId($est['id_partido']);
$jornada   = $partido['jornada'] ?? '—';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Detalle de Estadística</h1>
<div class="mb-4">
  <a href="index.php" class="btn btn-secondary">&larr; Volver a listado</a>
  <a href="edit.php?id=<?= urlencode($id) ?>" class="btn btn-warning">Editar</a>
  <a href="delete.php?id=<?= urlencode($id) ?>" class="btn btn-danger"
     onclick="return confirm('¿Eliminar esta estadística?');">
    Eliminar
  </a>
</div>

<table class="table table-bordered w-auto">
  <tr><th>Estadística ID</th><td><?= htmlspecialchars($est['id_estadistica']) ?></td></tr>
  <tr><th>Partido (Jornada)</th><td>ID <?= htmlspecialchars($est['id_partido']) ?> – Jornada <?= htmlspecialchars($jornada) ?></td></tr>
  <tr><th>Corners Local</th><td><?= htmlspecialchars($est['corners_local']) ?></td></tr>
  <tr><th>Corners Visitante</th><td><?= htmlspecialchars($est['corners_visitante']) ?></td></tr>
  <tr><th>Faltas Local</th><td><?= htmlspecialchars($est['faltas_local']) ?></td></tr>
  <tr><th>Faltas Visitante</th><td><?= htmlspecialchars($est['faltas_visitante']) ?></td></tr>
  <tr><th>Ám. Local</th><td><?= htmlspecialchars($est['tarjetas_amarillas_local']) ?></td></tr>
  <tr><th>Ám. Visitante</th><td><?= htmlspecialchars($est['tarjetas_amarillas_visitante']) ?></td></tr>
  <tr><th>Roj. Local</th><td><?= htmlspecialchars($est['tarjetas_rojas_local']) ?></td></tr>
  <tr><th>Roj. Visitante</th><td><?= htmlspecialchars($est['tarjetas_rojas_visitante']) ?></td></tr>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
