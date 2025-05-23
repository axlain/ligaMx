<?php
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// obtengo todos los equipos (son arrays asociativos con keys: id_equipo, nombre, logo…)
$equipos = EquipoService::obtenerTodos();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Equipos Registrados</h1>
<div class="row">
  <?php foreach($equipos as $eq):
      // ruta web absoluta: /ligaMx/src/equipo/img/<logo>
      $imgPath = '/ligaMx/src/equipo/img/' . ($eq['logo'] ?? '');
      $id      = urlencode($eq['id_equipo']);
  ?>
    <div class="col-md-3 mb-4">
      <div class="card card-team text-center">
        <img 
          src="<?= htmlspecialchars($imgPath) ?>" 
          class="card-img-top mx-auto" 
          alt="<?= htmlspecialchars($eq['nombre'] ?? '') ?>">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($eq['nombre'] ?? '') ?></h5>
          <div class="d-grid gap-2">
            <!-- Botón: Ver jugadores de este equipo -->
            <a href="../jugador/index.php?equipo=<?= $id ?>"
               class="btn btn-sm btn-primary">
              Ver Jugadores
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
