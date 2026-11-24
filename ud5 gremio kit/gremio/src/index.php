<?php

declare(strict_types=1);
require_once __DIR__ . '/inc/sesion.php';
iniciarSesion();
header('Location: ' . (aventureroActual() === null ? 'login.php' : 'tablon.php'));
exit;
