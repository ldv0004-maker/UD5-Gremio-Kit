<?php


declare(strict_types=1);

function conectar(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host     = getenv('MYSQL_HOST') ?: 'db';
        $baseDatos = getenv('MYSQL_DATABASE') ?: 'dbname';
        $usuario  = getenv('MYSQL_USER') ?: 'dbuser';
        $clave    = getenv('MYSQL_PASSWORD') ?: '';

        $dsn = "mysql:host={$host};dbname={$baseDatos};charset=utf8mb4";

        $pdo = new PDO($dsn, $usuario, $clave, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    return $pdo;
}
