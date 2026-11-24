<?php
declare(strict_types=1);

const RANGOS = ['E', 'D', 'C', 'B', 'A', 'S'];

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function etiquetaRango(string $rango): string
{
    return match ($rango) {
        'E'     => 'Novato',
        'D'     => 'Aprendiz',
        'C'     => 'Veterano',
        'B'     => 'Experto',
        'A'     => 'Élite',
        'S'     => 'Leyenda',
        default => 'Desconocido',
    };
}

function claseRango(string $rango): string
{
    return match ($rango) {
        'E', 'D' => 'facil',
        'C', 'B' => 'media',
        'A', 'S' => 'dificil',
        default  => '',
    };
}

function formatearOro(int $oro): string
{
    return number_format($oro, 0, ',', '.') . ' mo';
}

function filtrarMisiones(array $misiones, ?string $rango, int $oroMinimo): array
{
    $resultado = [];
    foreach ($misiones as $mision) {
        $cumpleRango = $rango === null || $mision['rango'] === $rango;
        $cumpleOro   = $mision['recompensa'] >= $oroMinimo;
        if ($cumpleRango && $cumpleOro) {
            $resultado[] = $mision;
        }
    }
    return $resultado;
}

function buscarMision(array $misiones, string $id): ?array
{
    foreach ($misiones as $mision) {
        if ($mision['id'] === $id) {
            return $mision;
        }
    }
    return null;
}

function totalRecompensa(array $misiones, array $ids): int
{
    $total = 0;
    foreach ($ids as $id) {
        $mision = buscarMision($misiones, (string) $id);
        if ($mision !== null) {
            $total += $mision['recompensa'];
        }
    }
    return $total;
}

function leerRangoFiltro(array $get): ?string
{
    $rango = $get['rango'] ?? null;
    if (!is_string($rango)) {
        return null;
    }
    $rango = strtoupper(trim($rango));
    return in_array($rango, RANGOS, true) ? $rango : null;
}

function leerOroMinimo(array $get): int
{
    $oro = filter_var(
        $get['oro'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 0, 'max_range' => 10000]]
    );
    return $oro === false ? 0 : $oro;
}
