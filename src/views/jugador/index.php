<?php
require_once __DIR__ . '/../../jugador/services/JugadorService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// cargo datos
$jugadores = JugadorService::obtenerTodos();    // array de ['id_jugador','nombre','id_equipo','posicion','fecha_nacimiento',…]
$equipos    = EquipoService::obtenerTodos();    // array de ['id_equipo','nombre','logo',…]

// índice equipos por id para buscar nombre
$mapEquipo = array_column($equipos, 'nombre', 'id_equipo');

// filtros GET
$nombre   = $_GET['nombre']   ?? '';
$equipoId = $_GET['equipo']   ?? '';

// aplico filtros
if ($nombre !== '') {
  $jugadores = array_filter($jugadores, fn($j)=>
    stripos($j['nombre'], $nombre)!==false
  );
}
if ($equipoId !== '') {
  $jugadores = array_filter($jugadores, fn($j)=>
    $j['id_equipo'] == $equipoId
  );
}

// función para calcular edad a partir de fecha YYYY-mm-dd
function calcularEdad($fechaNacimiento) {
  $nac = new DateTime($fechaNacimiento);
  $hoy = new DateTime();
  return $hoy->diff($nac)->y;
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Jugadores</h1>

<form class="row g-3 mb-3" method="get">
  <div class="col-md-4">
    <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
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
      <th>Edad</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($jugadores as $j): ?>
      <?php
        $eqName = $mapEquipo[$j['id_equipo']] ?? '—';
        $edad   = calcularEdad($j['fecha_nacimiento']);
      ?>
      <tr>
        <td><?= htmlspecialchars($j['nombre']) ?></td>
        <td><?= htmlspecialchars($eqName) ?></td>
        <td><?= $edad ?></td>
        <td class="table-actions">
          <a href="edit.php?id=<?= $j['id_jugador'] ?>"
             class="btn btn-sm btn-warning">Editar</a>
          <a href="delete.php?id=<?= $j['id_jugador'] ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar jugador?');">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; 

?>
