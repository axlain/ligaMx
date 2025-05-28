<?php
session_start();
session_unset();
session_destroy();

// Redirige directamente al listado de equipos
header('Location: /ligaMx/src/views/equipo/index.php');
exit;
