<?php
// src/views/usuario/index.php
session_start();

// Config y servicios
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../usuario/services/UsuarioService.php';

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id_usuario, nombre, contraseña FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        if ($user['contraseña'] === $password) {
            // Login OK: guardamos sesión y vamos a equipos
            $_SESSION['usuario_id']     = $user['id_usuario'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            header('Location: ../equipo/index.php');
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "No existe ningún usuario con ese email.";
    }
    $stmt->close();
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h2>Iniciar sesión</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" action="">
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Entrar</button>
  <a href="create.php" class="btn btn-link">Crear usuario</a>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
