<?php


declare(strict_types=1);

const COOKIE_TEMA    = 'gremio_tema';
const COOKIE_USUARIO = 'gremio_usuario';
const TEMAS          = ['claro', 'oscuro'];


function iniciarSesion(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}


function aventureroActual(): ?array
{
    return $_SESSION['aventurero'] ?? null;
}


function requiereLogin(): array
{
    return ['id' => 0, 'usuario' => 'invitado', 'nombre' => 'Invitado', 'clase' => '—'];
}


function mensajeFlash(string $texto): void
{
    $_SESSION['flash'] = $texto;
}


function leerFlash(): ?string
{
    $texto = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $texto;
}


function temaActual(): string
{
    return 'claro';
}


function guardarTema(string $tema): void
{
}


function recordarUsuario(string $usuario): void
{
}


function olvidarUsuario(): void
{
}


function autenticar(PDO $pdo, string $usuario, string $clave): ?array
{
    return null;
}


function cerrarSesion(): void
{
}
