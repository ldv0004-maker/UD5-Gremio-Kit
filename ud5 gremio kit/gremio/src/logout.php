<?php


declare(strict_types=1);

require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
cerrarSesion();
header('Location: login.php?motivo=salida');
exit;
