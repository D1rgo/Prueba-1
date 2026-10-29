<?php
require_once __DIR__ . '/../config.php';
metodo('POST'); protegerApi();
$d = entrada(); $id = idValido($d['id'] ?? null);
if (!$id) responder(['error' => 'ID válido obligatorio'], 422);
$personas = leerJson('participantes');
foreach ($personas as $i => $persona) {
    if ((int)$persona['id'] !== $id) continue;
    $nombre = trim((string)($d['nombre'] ?? $persona['nombre']));
    $apellido = trim((string)($d['apellido'] ?? $persona['apellido']));
    $numero = numeroValido($d['numero_rifa'] ?? $persona['numero_rifa']);
    if ($nombre === '' || $apellido === '' || !$numero) responder(['error' => 'Datos inválidos'], 422);
    foreach ($personas as $otra) {
        if ((int)$otra['id'] !== $id && (int)$otra['numero_rifa'] === $numero) responder(['error' => 'Número de rifa ocupado'], 409);
    }
    $personas[$i] = ['id' => $id, 'nombre' => $nombre, 'apellido' => $apellido, 'numero_rifa' => $numero];
    if (!guardarJson('participantes', $personas)) responder(['error' => 'No se pudo guardar'], 500);
    responder(['mensaje' => 'Participante actualizado', 'participante' => $personas[$i]]);
}
responder(['error' => 'Participante no encontrado'], 404);
