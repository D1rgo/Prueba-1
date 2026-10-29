<?php
require_once __DIR__ . '/config.php'; protegerWeb();
$archivos = array_values(array_filter(scandir(__DIR__ . '/comprobantes/') ?: [], function($nombre) {
    return $nombre !== '.' && $nombre !== '..' && is_file(__DIR__ . '/comprobantes/' . $nombre) && preg_match('/^[a-f0-9]{24}\.(pdf|jpg|jpeg|png)$/', $nombre);
}));
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Comprobantes</title><link rel="stylesheet" href="estilos.css"></head><body><main><section class="tarjeta"><h1>Archivos cargados</h1><?php if (!$archivos): ?><p>No hay comprobantes todavía.</p><?php else: ?><ul><?php foreach ($archivos as $archivo): ?><li><?=h($archivo)?></li><?php endforeach; ?></ul><?php endif; ?><a href="panel.php">Volver al panel</a></section></main></body></html>
