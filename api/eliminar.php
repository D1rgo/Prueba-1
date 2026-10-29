<?php
require_once __DIR__ . '/../config.php';
metodo('GET'); protegerApi();
$id = idValido($_GET['id'] ?? null);
if (!$id) responder(['error' => 'ID válido obligatorio'], 422);
$personas = leerJson('participantes');
$filtradas = array_values(array_filter($personas, fn($p) => (int)$p['id'] !== $id));
if (count($filtradas) === count($personas)) responder(['error' => 'Participante no encontrado'], 404);
if (!guardarJson('participantes', $filtradas)) responder(['error' => 'No se pudo guardar'], 500);
responder(['mensaje' => 'Participante eliminado', 'id' => $id]);
