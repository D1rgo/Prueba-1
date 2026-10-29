<?php
require_once __DIR__ . '/config.php';
if (autenticado()) { header('Location: panel.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuesta = trim((string)($_POST['captcha'] ?? ''));
    $correcto = ctype_digit($respuesta) && (int)$respuesta === ($_SESSION['captcha_resultado'] ?? -1);
    if (($_POST['usuario'] ?? '') === USUARIO && ($_POST['contrasena'] ?? '') === CLAVE && $correcto) {
        session_regenerate_id(true);
        $_SESSION['autenticado'] = true;
        unset($_SESSION['captcha_resultado']);
        header('Location: panel.php'); exit;
    }
    $error = 'Usuario, contraseña o CAPTCHA incorrecto.';
}
if (!isset($_SESSION['captcha_resultado']) || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = random_int(1, 10); $b = random_int(1, 10);
    $_SESSION['captcha_pregunta'] = "$a + $b";
    $_SESSION['captcha_resultado'] = $a + $b;
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Ingreso a la rifa</title><link rel="stylesheet" href="estilos.css"></head><body><main><section class="tarjeta"><h1>Ingreso al sistema de rifas</h1><p></p><?php if($error): ?><p class="error"><?=h($error)?></p><?php endif; ?><form method="post"><label>Usuario</label><input name="usuario" required autocomplete="username"><label>Contraseña</label><input name="contrasena" type="password" required autocomplete="current-password"><label>CAPTCHA: ¿Cuánto es <?=h($_SESSION['captcha_pregunta'])?>?</label><input name="captcha" type="number" required><button type="submit">Ingresar</button></form><small></small></section></main></body></html>
