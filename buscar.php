<?php
require_once __DIR__ . '/config.php'; protegerWeb();
$personas = [
 ['nombre'=>'Universidad','apellido'=>'Playa Ancha','ciudad'=>'Valparaiso','categoria'=>'Grupo A'],
 ['nombre'=>'Ana','apellido'=>'Gonzalez','ciudad'=>'Santiago','categoria'=>'Grupo B'],
 ['nombre'=>'Pedro','apellido'=>'Rojas','ciudad'=>'Vina del Mar','categoria'=>'Grupo C'],
 ['nombre'=>'Maria','apellido'=>'Soto','ciudad'=>'Quilpue','categoria'=>'Grupo A']
];
$resultado = null;
if (isset($_GET['buscar'])) {
    $campos = ['nombre','apellido','ciudad','categoria'];
    $resultado = false;
    foreach ($personas as $persona) {
        $coincide = true;
        foreach ($campos as $campo) {
            if (mb_strtolower(trim((string)($_GET[$campo] ?? '')), 'UTF-8') !== mb_strtolower($persona[$campo], 'UTF-8')) $coincide = false;
        }
        if ($coincide) { $resultado = true; break; }
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Buscar participantes</title><link rel="stylesheet" href="estilos.css"></head><body><main><section class="tarjeta"><h1>Búsqueda de participantes</h1><form method="get"><?php foreach(['nombre'=>'Nombre','apellido'=>'Apellido','ciudad'=>'Ciudad','categoria'=>'Categoría'] as $campo=>$titulo): ?><label for="<?=h($campo)?>"><?=h($titulo)?></label><input id="<?=h($campo)?>" name="<?=h($campo)?>" value="<?=h($_GET[$campo]??'')?>" required><?php endforeach; ?><button name="buscar" value="1">Buscar</button></form><?php if ($resultado !== null): ?><p class="<?=$resultado?'exito':'error'?>"><strong><?=$resultado?'Participante encontrado':'Participante no encontrado'?></strong></p><?php endif; ?><a href="panel.php">Volver al panel</a></section></main></body></html>
