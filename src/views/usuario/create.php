<?php
// src/views/usuario/create.php
session_start();

// Config, servicio y modelo
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../usuario/services/UsuarioService.php';
require_once __DIR__ . '/../../usuario/models/Usuario.php';
require_once __DIR__ . '/../../equipo/services/EquipoService.php';

$error = null;

// Lista de equipos
$equipos = EquipoService::obtenerTodos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre          = trim($_POST['nombre']);
    $email           = trim($_POST['email']);
    $password        = trim($_POST['password']);
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $favEquipos      = $_POST['equipos'] ?? [];

    try {
        // 1. Crear usuario
        UsuarioService::crearUsuario($nombre, $email, $password, $fechaNacimiento);

        // 2. Recuperar ID del nuevo usuario
        $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $idUsuario = $row['id_usuario'];
        $stmt->close();

        // 3. Agregar preferencias (es un usuario nuevo, no hay que eliminar nada)
        foreach ($favEquipos as $idEquipo) {
            Usuario::agregarPreferencia($idUsuario, (int)$idEquipo);
        }

        // 4. Iniciar sesión y redirigir a equipos
        $_SESSION['usuario_id']     = $idUsuario;
        $_SESSION['usuario_nombre'] = $nombre;
        header('Location: ../equipo/index.php');
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h2>Crear nuevo usuario</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" action="">
  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <div class="mb-3">
    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
  </div>
  <fieldset class="mb-3">
    <legend>Equipos favoritos</legend>
    <?php foreach ($equipos as $equipo): ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox"
               name="equipos[]" value="<?= htmlspecialchars($equipo['id_equipo']) ?>"
               id="eq<?= $equipo['id_equipo'] ?>">
        <label class="form-check-label" for="eq<?= $equipo['id_equipo'] ?>">
          <?= htmlspecialchars($equipo['nombre']) ?>
        </label>
      </div>
    <?php endforeach; ?>
  </fieldset>
  <button type="submit" class="btn btn-success">Crear usuario</button>
  <a href="index.php" class="btn btn-link">Volver al login</a>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
