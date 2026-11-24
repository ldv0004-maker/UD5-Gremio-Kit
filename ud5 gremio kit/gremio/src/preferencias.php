<?php


declare(strict_types=1);

require_once __DIR__ . '/inc/funciones.php';
require_once __DIR__ . '/inc/sesion.php';

iniciarSesion();
$aventurero = requiereLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}

$temaGuardado = temaActual();
$flash = leerFlash();

$titulo = 'Preferencias';
require __DIR__ . '/inc/cabecera.php';
?>
<section class="tarjeta estrecha">
    <h1>Preferencias</h1>
    <?php if ($flash !== null): ?><p class="aviso"><?= e($flash) ?></p><?php endif; ?>
    <form method="post" action="preferencias.php">
        <fieldset>
            <legend>Tema del tablón</legend>
            <?php foreach (TEMAS as $opcion): ?>
                <label class="casilla">
                    <input type="radio" name="tema" value="<?= $opcion ?>" <?= $opcion === $temaGuardado ? 'checked' : '' ?>>
                    <?= ucfirst($opcion) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>
        <button type="submit">Guardar</button>
    </form>
    
</section>
<?php require __DIR__ . '/inc/pie.php'; ?>
