<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/funciones.php';
require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
$aventurero = requiereLogin();
$misiones   = require __DIR__ . '/inc/datos_misiones.php';
$_SESSION['zurron'] ??= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $id = is_string($id) ? $id : '';
    $mision = buscarMision($misiones, $id);

    if ($mision === null) {
        mensajeFlash('Esa misión no existe en el tablón.');
    } elseif (in_array($id, $_SESSION['zurron'], true)) {
        mensajeFlash('Ya llevas «' . $mision['titulo'] . '» en tu zurrón.');
    } else {
        $_SESSION['zurron'][] = $id;
        mensajeFlash('Has aceptado «' . $mision['titulo'] . '». ¡Suerte, aventurero!');
    }

    header('Location: tablon.php');
    exit;
}

$rango     = leerRangoFiltro($_GET);
$oroMinimo = leerOroMinimo($_GET);
$visibles  = filtrarMisiones($misiones, $rango, $oroMinimo);
$flash     = leerFlash();

$titulo = 'Tablón de misiones';
require __DIR__ . '/inc/cabecera.php';
?>
<h1>Tablón de misiones</h1>
<?php if ($flash !== null): ?><p class="aviso"><?= e($flash) ?></p><?php endif; ?>

<form method="get" action="tablon.php" class="filtros">
    <label>Rango
        <select name="rango">
            <option value="">Todos</option>
            <?php foreach (RANGOS as $r): ?>
                <option value="<?= $r ?>" <?= $r === $rango ? 'selected' : '' ?>><?= $r ?> · <?= etiquetaRango($r) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Recompensa mínima
        <input type="number" name="oro" min="0" max="10000" step="10" value="<?= $oroMinimo ?>">
    </label>
    <button type="submit">Filtrar</button>
</form>

<p><?= count($visibles) ?> de <?= count($misiones) ?> misiones.</p>

<div class="misiones">
<?php foreach ($visibles as $mision): ?>
    <article class="mision <?= e(claseRango($mision['rango'])) ?>">
        <span class="rango"><?= e($mision['rango']) ?> · <?= e(etiquetaRango($mision['rango'])) ?></span>
        <h2><?= e($mision['titulo']) ?></h2>
        <p class="nota"><?= e($mision['zona']) ?> · <?= $mision['dias'] === 1 ? '1 día' : (int) $mision['dias'] . ' días' ?></p>
        <p><?= e($mision['descripcion']) ?></p>
        <p class="oro"><?= e(formatearOro($mision['recompensa'])) ?></p>
        <?php if (in_array($mision['id'], $_SESSION['zurron'], true)): ?>
            <p class="hecho">✔ En tu zurrón</p>
        <?php else: ?>
            <form method="post" action="tablon.php">
                <input type="hidden" name="id" value="<?= e($mision['id']) ?>">
                <button type="submit">Aceptar misión</button>
            </form>
        <?php endif; ?>
    </article>
<?php endforeach; ?>
<?php if (count($visibles) === 0): ?>
    <p>Ninguna misión cumple el filtro.</p>
<?php endif; ?>
</div>
<?php require __DIR__ . '/inc/pie.php'; ?>
