<?php
require_once __DIR__ . '/../config.php';
metodo('POST');
$d = entrada();
if (($d['usuario'] ?? '') !== USUARIO || ($d['contrasena'] ?? '') !== CLAVE) {
    responder(['error' => 'Credenciales incorrectas'], 401);
}
session_regenerate_id(true);
$_SESSION['autenticado'] = true;
responder(['mensaje' => 'Sesión iniciada correctamente']);
