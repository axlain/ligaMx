<?php
require_once __DIR__ . '/../../jugador/services/JugadorService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// filtros GET
$nombre   = $_GET['nombre'] ?? '';
$equipoId = $_GET['equipo'] ?? '';

// obtengo jugadores con filtrado del Service
$jugadores = JugadorService::obtenerTodos($nombre, $equipoId);

// obtengo para el select de equipos
$equipos = EquipoService::obtenerTodos();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Jugadores</h1>

<form class="row g-3 mb-3" method="get">
  <div class="col-md-4">
    <input type="text" name="nombre" class="form-control"
           placeholder="Buscar por nombre"
           value="<?= htmlspecialchars($nombre) ?>">
  </div>
  <div class="col-md-4">
    <select name="equipo" class="form-select">
      <option value="">-- Todos los equipos --</option>
      <?php foreach($equipos as $eq): ?>
        <option value="<?= $eq['id_equipo'] ?>"
          <?= $equipoId == $eq['id_equipo'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($eq['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4">
    <button class="btn btn-primary" type="submit">Filtrar</button>
    <a href="add.php" class="btn btn-success">Agregar Jugador</a>
  </div>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Equipo</th>
      <th>Posición</th>
      <th>Edad</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($jugadores as $j): 
      // calculo edad
      $nac   = new DateTime($j['fecha_nacimiento']);
      $edad  = (new DateTime())->diff($nac)->y;
      // obtengo nombre de equipo
      $eq    = array_filter($equipos, fn($e)=> $e['id_equipo']==$j['id_equipo']);
      $eq    = $eq ? array_shift($eq)['nombre'] : '—';
    ?>
      <tr>
        <td><?= htmlspecialchars($j['nombre']) ?></td>
        <td><?= htmlspecialchars($eq) ?></td>
        <td><?= htmlspecialchars($j['posicion']) ?></td>
        <td><?= $edad ?></td>
        <td class="table-actions">
          <a href="edit.php?id=<?= $j['id_jugador'] ?>"
             class="btn btn-sm btn-warning">Editar</a>
          <!-- opción Eliminar eliminada según tu petición -->
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
