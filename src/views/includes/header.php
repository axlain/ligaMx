<?php
// src/views/includes/header.php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liga MX</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS común -->
  <link rel="stylesheet" href="<?= dirname(__DIR__) ?>/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/ligaMx/">Liga MX</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/ligaMx/src/views/equipo/index.php">Equipos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/ligaMx/src/views/jugador/index.php">Jugadores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/ligaMx/src/views/partido/index.php">Partidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/ligaMx/src/views/estadisticaPartido/index.php">Estadísticas de Partido</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['usuario_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="/ligaMx/src/views/usuario/logout.php">
              Cerrar sesión (<?= htmlspecialchars($_SESSION['usuario_nombre']) ?>)
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/ligaMx/src/views/usuario/index.php">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/ligaMx/src/views/usuario/create.php">Registrarse</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
