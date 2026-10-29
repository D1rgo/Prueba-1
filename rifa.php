<?php
require_once __DIR__ . '/config.php'; protegerWeb();
if (!isset($_SESSION['cantidad_rifa'])) $_SESSION['cantidad_rifa'] = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'agregar') $_SESSION['cantidad_rifa']++;
    if ($accion === 'quitar') $_SESSION['cantidad_rifa'] = max(0, $_SESSION['cantidad_rifa'] - 1);
    header('Location: rifa.php'); exit;
}
$cantidad = max(0, (int)$_SESSION['cantidad_rifa']); $total = $cantidad * PRECIO_RIFA;
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Reservar rifa</title><link rel="stylesheet" href="estilos.css"></head><body><main><section class="tarjeta"><h1>Reserva de números</h1><p>Cantidad reservada: <strong><?=$cantidad?></strong></p><p>Precio por número: <strong>$<?=number_format(PRECIO_RIFA,0,',','.')?></strong></p><p>Total a pagar: <strong>$<?=number_format($total,0,',','.')?></strong></p><form method="post"><button name="accion" value="agregar">+ Agregar número</button><button name="accion" value="quitar">− Quitar número</button></form><p><small>La cantidad se conserva al actualizar la página con F5.</small></p><a href="panel.php">Volver al panel</a></section></main></body></html>
