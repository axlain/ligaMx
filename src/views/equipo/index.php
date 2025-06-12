<?php
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

// obtengo todos los equipos (arrays asociativos con keys: id_equipo, nombre, logo…)
$equipos = EquipoService::obtenerTodos();

// mapeo de nombres de equipo en BD a nombres de archivo de imagen (sin extensión)
$imagenPorEquipo = [
    'America'           => 'america',
    'Atlas'             => 'atlas',
    'Chivas'            => 'chivas',
    'Cruz Azul'         => 'cruz_azul',
    'Guadalajara'       => 'guadalajara',
    'Juaréz'            => 'juarez',
    'León'              => 'leon',
    'Mazatlán'          => 'mazatlan',
    'Monterrey'         => 'monterrey',
    'Necaxa'            => 'necaxa',
    'Pachuca'           => 'pachuca',
    'Puebla'            => 'puebla',
    'Pumas UNAM'        => 'pumas',
    'Querétaro'         => 'queretaro',
    'Atlético San Luis' => 'san_luis',
    'Santos Laguna'     => 'santos',
    'Tigres UANL'       => 'tigres',
    'Tijuana'           => 'tijuana',
    'Toluca'            => 'toluca',
];
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<h1>Equipos Registrados</h1>
<div class="row">
  <?php foreach($equipos as $eq):
      $nombreBd = $eq['nombre'] ?? '';
      $claveImg = $imagenPorEquipo[$nombreBd] ?? null;
      // ruta web absoluta apuntando al directorio img
      $imgSrc   = $claveImg
                  ? "/ligaMx/src/equipo/img/{$claveImg}.png"
                  : "/ligaMx/src/equipo/img/default.png";
      $id       = urlencode($eq['id_equipo']);
  ?>
    <div class="col-md-3 mb-4">
      <div class="card card-team text-center">
        <img 
          src="<?= htmlspecialchars($imgSrc) ?>"
          alt="<?= htmlspecialchars($nombreBd) ?>"
          class="card-img-top mx-auto"
          style="width:150px; height:150px; object-fit:contain;">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($nombreBd) ?></h5>
          <div class="d-grid gap-2">
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
