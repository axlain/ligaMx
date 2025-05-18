<?php
require_once __DIR__ . '/../../estadisticaPartido/services/EstadisticaPartidoService.php';
require_once __DIR__ . '/../../partido/services/PartidoService.php';

// obtengo todos los partidos para el select
$partidos = PartidoService::obtenerTodos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id_partido'                   => $_POST['partido']                  ?? '',
        'corners_local'                => $_POST['corners_local']            ?? 0,
        'corners_visitante'            => $_POST['corners_visitante']        ?? 0,
        'faltas_local'                 => $_POST['faltas_local']             ?? 0,
        'faltas_visitante'             => $_POST['faltas_visitante']         ?? 0,
        'tarjetas_amarillas_local'     => $_POST['tarjetas_amarillas_local'] ?? 0,
        'tarjetas_amarillas_visitante' => $_POST['tarjetas_amarillas_visitante'] ?? 0,
        'tarjetas_rojas_local'         => $_POST['tarjetas_rojas_local']     ?? 0,
        'tarjetas_rojas_visitante'     => $_POST['tarjetas_rojas_visitante'] ?? 0,
    ];
    EstadisticaPartidoService::agregar($datos);
    header('Location: index.php');
    exit;
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Agregar Estadística de Partido</h1>
<form action="add.php" method="post" class="row g-3">
  <div class="col-md-6">
    <label for="partido" class="form-label">Partido (ID)</label>
    <select name="partido" id="partido" class="form-select" required>
      <option value="">-- Selecciona un partido --</option>
      <?php foreach($partidos as $p): ?>
        <option value="<?= htmlspecialchars($p['id_partido']) ?>">
          ID <?= $p['id_partido'] ?> – Jornada <?= htmlspecialchars($p['jornada']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <?php 
    $fields = [
      'corners_local'                => 'Corners Local',
      'corners_visitante'            => 'Corners Visitante',
      'faltas_local'                 => 'Faltas Local',
      'faltas_visitante'             => 'Faltas Visitante',
      'tarjetas_amarillas_local'     => 'Tarjetas Amarillas Local',
      'tarjetas_amarillas_visitante' => 'Tarjetas Amarillas Visitante',
      'tarjetas_rojas_local'         => 'Tarjetas Rojas Local',
      'tarjetas_rojas_visitante'     => 'Tarjetas Rojas Visitante',
    ];
    foreach($fields as $name => $label):
  ?>
    <div class="col-md-6">
      <label for="<?= $name ?>" class="form-label"><?= $label ?></label>
      <input type="number" name="<?= $name ?>" id="<?= $name ?>"
             class="form-control" value="0" min="0" required>
    </div>
  <?php endforeach; ?>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Guardar Estadística</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
