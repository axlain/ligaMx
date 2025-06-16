<?php
require_once __DIR__ . '/../../jugador/services/JugadorService.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// obtengo lista de equipos para el select
$equipos = EquipoService::obtenerTodos();

// ID del jugador a editar
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// obtengo datos actuales
$jugador = JugadorService::obtenerPorId($id);
if (!$jugador) {
    // si no existe, vuelvo al listado
    header('Location: index.php');
    exit;
}

// convertir a array si viene como objeto
$J = is_array($jugador) ? $jugador : (array)$jugador;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Reúno datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $id_equipo = $_POST['equipo'] ?? '';
    $posicion = $_POST['posicion'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

    // llamo al método correcto del service
    JugadorService::actualizarJugador($id, $nombre, $id_equipo, $posicion, $fecha_nacimiento);

    // redirijo al listado
    header('Location: index.php');
    exit;
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Editar Jugador</h1>
<form action="edit.php?id=<?= urlencode($id) ?>" method="post" class="row g-3">
  <div class="col-md-6">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre"
           class="form-control"
           value="<?= htmlspecialchars($J['nombre']) ?>"
           required>
  </div>
  <div class="col-md-6">
    <label for="equipo" class="form-label">Equipo</label>
    <select name="equipo" id="equipo" class="form-select" required>
      <option value="">-- Elige un equipo --</option>
      <?php foreach($equipos as $eq): 
        $selected = $eq['id_equipo'] == $J['id_equipo'] ? 'selected' : '';
      ?>
        <option value="<?= htmlspecialchars($eq['id_equipo']) ?>" <?= $selected ?>>
          <?= htmlspecialchars($eq['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-6">
    <label for="posicion" class="form-label">Posición</label>
    <input type="text" name="posicion" id="posicion"
           class="form-control"
           value="<?= htmlspecialchars($J['posicion']) ?>"
           required>
  </div>
  <div class="col-md-6">
    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
           class="form-control"
           value="<?= htmlspecialchars($J['fecha_nacimiento']) ?>"
           required>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-warning">Actualizar Datos</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
