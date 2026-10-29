<?php
require_once __DIR__ . '/../config.php';
metodo('POST'); protegerApi();
$d = entrada();
$nombre = trim((string)($d['nombre'] ?? ''));
$apellido = trim((string)($d['apellido'] ?? ''));
$numero = numeroValido($d['numero_rifa'] ?? null);
if ($nombre === '' || $apellido === '' || !$numero) responder(['error' => 'Nombre, apellido y número de rifa positivo son obligatorios'], 422);
$personas = leerJson('participantes');
foreach ($personas as $persona) {
    if ((int)$persona['numero_rifa'] === $numero) responder(['error' => 'Número de rifa ya registrado'], 409);
}
$id = empty($personas) ? 1 : max(array_map(fn($x) => (int)$x['id'], $personas)) + 1;
$nuevo = ['id' => $id, 'nombre' => $nombre, 'apellido' => $apellido, 'numero_rifa' => $numero];
$personas[] = $nuevo;
if (!guardarJson('participantes', $personas)) responder(['error' => 'No se pudo guardar'], 500);
responder(['mensaje' => 'Participante registrado', 'participante' => $nuevo], 201);
