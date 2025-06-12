<?php
require_once __DIR__ . '/../../jugador/services/JugadorService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// obtengo filtros GET
$nombre    = trim($_GET['nombre']    ?? '');
$equipoId  = $_GET['equipo']  ?? '';
$posicion  = trim($_GET['posicion']  ?? '');

// obtengo lista de jugadores según posición si se proporcionó
if ($posicion !== '') {
    $jugadores = JugadorService::obtenerPorPosicion($posicion);
} else {
    $jugadores = JugadorService::obtenerTodos();
}

// aplico filtros manuales sobre el array ya obtenido
if ($nombre !== '') {
    $jugadores = array_filter($jugadores, function($j) use ($nombre) {
        $n = is_array($j) ? $j['nombre'] : $j->nombre;
        return stripos($n, $nombre) !== false;
    });
}
if ($equipoId !== '') {
    $jugadores = array_filter($jugadores, function($j) use ($equipoId) {
        $idEq = is_array($j) ? $j['id_equipo'] : $j->id_equipo;
        return $idEq == $equipoId;
    });
}

// obtengo lista de equipos para el select y para mapear nombres
$equipos = EquipoService::obtenerTodos();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Jugadores</h1>

<form class="row g-3 mb-3" method="get">
  <div class="col-md-3">
    <input type="text" name="nombre" class="form-control"
           placeholder="Buscar por nombre"
           value="<?= htmlspecialchars($nombre) ?>">
  </div>
  <div class="col-md-3">
    <select name="equipo" class="form-select">
      <option value="">-- Todos los equipos --</option>
      <?php foreach($equipos as $eq): ?>
        <option value="<?= is_array($eq) ? $eq['id_equipo'] : $eq->id_equipo ?>"
          <?= $equipoId == (is_array($eq) ? $eq['id_equipo'] : $eq->id_equipo) ? 'selected' : '' ?>>
          <?= htmlspecialchars(is_array($eq) ? $eq['nombre'] : $eq->nombre) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3">
    <input type="text" name="posicion" class="form-control"
           placeholder="Filtrar por posición"
           value="<?= htmlspecialchars($posicion) ?>">
  </div>
  <div class="col-md-3">
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
        $J = is_array($j) ? $j : (array)$j;
        // calculo edad
        $nac   = new DateTime($J['fecha_nacimiento']);
        $edad  = (new DateTime())->diff($nac)->y;
        // obtengo nombre de equipo
        $eqObj = array_filter($equipos, fn($e)=>
            (is_array($e) ? $e['id_equipo'] : $e->id_equipo) == $J['id_equipo']
        );
        $eqObj = $eqObj ? array_shift($eqObj) : null;
        $eqName = $eqObj
            ? (is_array($eqObj) ? $eqObj['nombre'] : $eqObj->nombre)
            : '—';
    ?>
      <tr>
        <td><?= htmlspecialchars($J['nombre']) ?></td>
        <td><?= htmlspecialchars($eqName) ?></td>
        <td><?= htmlspecialchars($J['posicion']) ?></td>
        <td><?= $edad ?></td>
        <td class="table-actions">
          <a href="edit.php?id=<?= urlencode($J['id_jugador']) ?>"
             class="btn btn-sm btn-warning">Editar</a>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (empty($jugadores)): ?>
      <tr><td colspan="5" class="text-center">No se encontraron jugadores.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
