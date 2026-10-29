<?php
require_once __DIR__ . '/config.php'; protegerWeb();
$mensaje = ''; $error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['comprobante']) || $_FILES['comprobante']['error'] !== UPLOAD_ERR_OK) {
        $mensaje = 'Error al recibir el archivo.'; $error = true;
    } elseif ($_FILES['comprobante']['size'] > 5 * 1024 * 1024) {
        $mensaje = 'El archivo supera los 5 MB.'; $error = true;
    } else {
        $archivo = $_FILES['comprobante'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $permitidos = ['pdf'=>'application/pdf','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png'];
        $tipo = (new finfo(FILEINFO_MIME_TYPE))->file($archivo['tmp_name']);
        if (!isset($permitidos[$extension]) || $tipo !== $permitidos[$extension]) {
            $mensaje = 'Solo se permiten archivos PDF, JPG o PNG.'; $error = true;
        } else {
            $destino = __DIR__ . '/comprobantes/' . bin2hex(random_bytes(12)) . '.' . $extension;
            if (move_uploaded_file($archivo['tmp_name'], $destino)) $mensaje = 'Comprobante cargado correctamente.';
            else { $mensaje = 'No se pudo guardar el comprobante.'; $error = true; }
        }
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Subir comprobante</title><link rel="stylesheet" href="estilos.css"></head><body><main><section class="tarjeta"><h1>Subir comprobante</h1><?php if($mensaje): ?><p class="<?=$error?'error':'exito'?>"><?=h($mensaje)?></p><?php endif; ?><form method="post" enctype="multipart/form-data"><label>Archivo (PDF, JPG o PNG; máximo 5 MB)</label><input type="file" name="comprobante" accept=".pdf,.jpg,.jpeg,.png" required><button>Subir archivo</button></form><a href="panel.php">Volver al panel</a></section></main></body></html>
