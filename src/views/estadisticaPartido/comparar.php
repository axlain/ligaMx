<?php
session_start();

// Configuración y servicios
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';
require_once __DIR__ . '/../../estadisticaPartido/services/EstadisticaPartidoService.php';
require_once __DIR__ . '/../../estadisticaPartido/models/EstadisticaPartido.php';

$error    = null;
$totales  = null;
$detalles = null;

// Cargo lista de equipos para los <select>
$equipos = EquipoService::obtenerTodos();

// Leo parámetros GET
$idEq1 = isset($_GET['equipo1']) ? (int) $_GET['equipo1'] : null;
$idEq2 = isset($_GET['equipo2']) ? (int) $_GET['equipo2'] : null;

if ($idEq1 && $idEq2) {
    if ($idEq1 === $idEq2) {
        $error = "Debes elegir dos equipos diferentes.";
    } else {
        // Obtengo nombres de los equipos
        $e1 = EquipoService::obtenerPorId($idEq1);
        $e2 = EquipoService::obtenerPorId($idEq2);
        if (!$e1 || !$e2) {
            $error = "Alguno de los equipos seleccionados no existe.";
        } else {
            $nombre1 = $e1['nombre'];
            $nombre2 = $e2['nombre'];

            try {
                // Totales generales
                $totales  = EstadisticaPartidoService::compararTotalesPorEquipos($nombre1, $nombre2);
                // Detalle de partidos comparados
                $detalles = EstadisticaPartido::obtenerDetalleComparadoEquipos($nombre1, $nombre2);
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Comparar Estadísticas de Partido por Equipo</h2>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="get" class="row g-3 mb-4">
  <div class="col-md-5">
    <label for="equipo1" class="form-label">Equipo 1</label>
    <select id="equipo1" name="equipo1" class="form-select" required>
      <option value="">-- Selecciona --</option>
      <?php foreach ($equipos as $e): ?>
        <option value="<?= $e['id_equipo'] ?>"
          <?= ($idEq1 === (int)$e['id_equipo']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($e['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-5">
    <label for="equipo2" class="form-label">Equipo 2</label>
    <select id="equipo2" name="equipo2" class="form-select" required>
      <option value="">-- Selecciona --</option>
      <?php foreach ($equipos as $e): ?>
        <option value="<?= $e['id_equipo'] ?>"
          <?= ($idEq2 === (int)$e['id_equipo']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($e['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-2 align-self-end">
    <button type="submit" class="btn btn-primary w-100">Comparar</button>
  </div>
</form>

<?php if ($totales): ?>
  <!-- Totales generales -->
  <h3>Totales por Equipo</h3>
  <table class="table table-bordered mb-5">
    <thead>
      <tr>
        <th>Equipo</th>
        <th>Total Corners</th>
        <th>Total Faltas</th>
        <th>Total Amarillas</th>
        <th>Total Rojas</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($totales as $fila): ?>
        <tr>
          <td><?= htmlspecialchars(ucfirst($fila['equipo'])) ?></td>
          <td><?= htmlspecialchars($fila['total_corners']) ?></td>
          <td><?= htmlspecialchars($fila['total_faltas']) ?></td>
          <td><?= htmlspecialchars($fila['total_tarjetas_amarillas']) ?></td>
          <td><?= htmlspecialchars($fila['total_tarjetas_rojas']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Detalle de partidos comparados agrupados por jornada -->
  <h3>Detalle de Partidos Comparados</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Jornada</th>
        <th>Fecha</th>
        <th>Equipo</th>
        <th>Condición</th>
        <th>Corners</th>
        <th>Faltas</th>
        <th>Amarillas</th>
        <th>Rojas</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $ultimoJornada = null;
      foreach ($detalles as $p):
          // Cuando cambia la jornada, imprimimos una fila de separación con el título de la jornada
          if ($p['jornada'] !== $ultimoJornada):
              $ultimoJornada = $p['jornada'];
      ?>
        <tr class="table-active">
          <td colspan="8">Jornada <?= htmlspecialchars($ultimoJornada) ?></td>
        </tr>
      <?php endif; ?>
      <tr>
        <td><?= htmlspecialchars($p['jornada']) ?></td>
        <td><?= htmlspecialchars($p['fecha']) ?></td>
        <td><?= htmlspecialchars($p['equipo']) ?></td>
        <td><?= htmlspecialchars($p['condicion']) ?></td>
        <td><?= htmlspecialchars($p['corners']) ?></td>
        <td><?= htmlspecialchars($p['faltas']) ?></td>
        <td><?= htmlspecialchars($p['tarjetas_amarillas']) ?></td>
        <td><?= htmlspecialchars($p['tarjetas_rojas']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
