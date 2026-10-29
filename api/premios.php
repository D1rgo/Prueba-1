<?php
require_once __DIR__ . '/../config.php';
metodo('GET'); protegerApi();
responder(['premios' => leerJson('premios')]);
