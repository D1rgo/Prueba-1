<?php
// Configuración compartida del proyecto de evaluación.
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
const USUARIO = 'userupla';
const CLAVE = 'upla123';
const PRECIO_RIFA = 2000;
function rutaDatos(string $nombre): string { return __DIR__ . '/datos/' . $nombre . '.json'; }
function leerJson(string $nombre): array {
    $ruta = rutaDatos($nombre);
    if (!is_file($ruta)) return [];
    $datos = json_decode((string)file_get_contents($ruta), true);
    return is_array($datos) ? $datos : [];
}
function guardarJson(string $nombre, array $datos): bool {
    $ruta = rutaDatos($nombre);
    $archivo = fopen($ruta, 'c+');
    if (!$archivo) return false;
    try {
        if (!flock($archivo, LOCK_EX)) return false;
        ftruncate($archivo, 0);
        rewind($archivo);
        $json = json_encode(array_values($datos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $ok = $json !== false && fwrite($archivo, $json) === strlen($json);
        fflush($archivo);
        flock($archivo, LOCK_UN);
        return $ok;
    } finally { fclose($archivo); }
}
function autenticado(): bool { return ($_SESSION['autenticado'] ?? false) === true; }
function protegerWeb(): void {
    if (!autenticado()) { header('Location: index.php'); exit; }
}
function h($valor): string { return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8'); }
function responder(array $datos, int $codigo = 200): void {
    http_response_code($codigo);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}
function metodo(string $esperado): void {
    if ($_SERVER['REQUEST_METHOD'] !== $esperado) {
        header('Allow: ' . $esperado);
        responder(['error' => 'Método no permitido. Use ' . $esperado], 405);
    }
}
function protegerApi(): void {
    if (!autenticado()) responder(['error' => 'Debe iniciar sesión'], 401);
}
function entrada(): array {
    $tipo = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($tipo, 'application/json') !== false) {
        $datos = json_decode((string)file_get_contents('php://input'), true);
        return is_array($datos) ? $datos : [];
    }
    return $_POST;
}
function idValido($id): int { return filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0; }
function numeroValido($numero): int { return filter_var($numero, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0; }
