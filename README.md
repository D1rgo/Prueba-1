# Prueba 1: PHP y Servicios Web (UPLA)

Proyecto educativo con dos componentes independientes: API REST y sistema web PHP.

## Requisitos
- PHP 8.0 o superior, extensión `fileinfo` y `mbstring` activas.
- XAMPP (Apache + PHP) o servidor de desarrollo PHP.
- Postman para probar la API.

## Ejecutar en XAMPP
1. Descomprime `prueba_php_upla` dentro de `C:\xampp\htdocs\`.
2. Inicia **Apache** desde el panel de XAMPP.
3. Abre `http://localhost/prueba_php_upla/index.php`.
4. Usuario: `userupla` / Contraseña: `upla123`.
5. Resuelve el CAPTCHA, entra al panel y prueba las opciones.

También puedes abrir una terminal dentro de `prueba_php_upla` y ejecutar `php -S localhost:8000`, luego visitar `http://localhost:8000/index.php`. Para la prueba local, la carpeta `datos` debe permitir escritura al proceso PHP.

## Probar API en Postman
**Importante:** usa una única sesión de Postman, con cookies habilitadas, para conservar `PHPSESSID` entre solicitudes. El login de la API no requiere CAPTCHA (el CAPTCHA es de la web).

| Operación | Método | URL | Parámetros |
|---|---|---|---|
| Login | POST | `/api/login.php` | `usuario=userupla`, `contrasena=upla123` |
| Participantes | GET | `/api/participantes.php` | ninguno |
| Premios | GET | `/api/premios.php` | ninguno |
| Registrar | POST | `/api/registrar.php` | `nombre=Luis`, `apellido=Perez`, `numero_rifa=50` |
| Actualizar | POST | `/api/actualizar.php` | `id=5`, `nombre=Luis`, `apellido=Diaz`, `numero_rifa=51` |
| Eliminar | GET | `/api/eliminar.php?id=5` | ID en URL |
| Logout | GET | `/api/logout.php` | ninguno |

Ejemplo URL completa: `http://localhost/prueba_php_upla/api/login.php`.

En solicitudes POST, selecciona **Body → x-www-form-urlencoded** y agrega los parámetros de la tabla. También se acepta JSON con `Content-Type: application/json`. Para actualizar o eliminar, usa el ID que realmente devolvió la operación de registro.

### Verificaciones clave
- Antes del login, `GET /api/participantes.php` debe responder 401.
- Después del login, debe mostrar los participantes.
- Registrar, actualizar y eliminar deben modificar `datos/participantes.json`.
- Tras logout, las rutas protegidas deben responder 401.
- En la web, prueba una contraseña o CAPTCHA erróneo: debe rechazarse y cambiar el CAPTCHA.
- Intenta abrir `/panel.php` sin sesión: debe redirigir a `/index.php`.
- En `/rifa.php`, agrega y quita números, actualiza con F5 y comprueba el total a $2.000 por número y el mínimo de cero.
- En `/buscar.php`, usa `Universidad`, `Playa Ancha`, `Valparaiso`, `Grupo A` para encontrar el participante. Cambia un campo y debe indicar que no se encontró.
- Sube un PDF/JPG/PNG pequeño y comprueba que su nombre aparece en `/archivos.php`.

## Guion sugerido para el video (máximo 8 minutos)
1. (0:00–0:40) Presentar carpetas y archivos JSON.
2. (0:40–3:10) Postman: login, endpoints protegidos, registrar, actualizar y eliminar.
3. (3:10–3:40) Logout de API y rechazo sin sesión.
4. (3:40–4:45) Login web, CAPTCHA incorrecto/correcto y panel protegido.
5. (4:45–5:45) Reserva de números, quitar y F5.
6. (5:45–6:35) Búsqueda encontrada y no encontrada.
7. (6:35–7:20) Subir comprobante y ver archivos.
8. (7:20–7:50) Cerrar sesión y comprobar redirección.

## Entrega
Sube el código a un repositorio de GitHub y entrega el enlace junto con el video. No incluyas comprobantes reales, contraseñas reales ni información sensible. Las credenciales fijas de este proyecto son únicamente para la evaluación, no para producción.

## Nota técnica
El enunciado solicita explícitamente eliminación con GET, por eso la API sigue ese método aunque en aplicaciones reales se prefiere DELETE. El almacenamiento JSON es adecuado para esta práctica pequeña; no es una base de datos concurrente. Las reservas de `/rifa.php` almacenan la **cantidad** en sesión, tal como pide el enunciado, y no asignan identificadores individuales de boletos.
