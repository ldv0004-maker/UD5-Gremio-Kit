# Memoria · Gremio de Aventureros

**Código de alumno/a:** ______  (no pongas tu nombre)

## 1. Mi aventurero
- Usuario que he añadido a la tabla: ______
- Comando o pasos que he usado para generar el hash:
  `docker compose exec www php -r "echo password_hash('TuClave', PASSWORD_DEFAULT), PHP_EOL;"`
  y después, en phpMyAdmin, he insertado una fila en `aventureros` pegando ese hash en `password_hash`.

## 2. Parte 1 · match
¿Has puesto `default` en `etiquetaRango()`? ¿Qué pasa si llega el rango `'Z'`? ¿Por qué lo prefieres así?

Sí, he puesto `default => 'Desconocido'`. Un `match` es exhaustivo: si ningún brazo coincide y no hay `default`, PHP lanza una excepción `UnhandledMatchError` y la página se rompe. Con el `default`, si llega el rango `'Z'` la función devuelve «Desconocido» y la web sigue funcionando. Lo prefiero así porque el rango es un dato que puede venir mal y un valor inesperado no debe tumbar toda la página.

## 3. Parte 2 · Validación de la URL
Escribe a mano en la barra `tablon.php?rango=Z&oro=hola`. ¿Qué ocurre y qué línea de tu código lo evita?

No da ningún error: la página se muestra con todas las misiones (10 de 10), el desplegable en «Todos» y la recompensa mínima en 0. El rango `Z` lo descarta la línea `return in_array($rango, RANGOS, true) ? $rango : null;` de `leerRangoFiltro()`, que solo acepta valores que estén en `RANGOS`. El oro `hola` lo descarta `filter_var(..., FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 10000]])` en `leerOroMinimo()`, que devuelve `false` y yo lo convierto en 0.

## 4. Parte 3 · Sesión frente a cookie
Explica con tus palabras qué guardas en `$_SESSION` y qué guardas en cookies, y por qué no al revés.

## 5. Parte 3 · Seguridad del login
- ¿Qué pasa si en el usuario escribes `' OR '1'='1`? ¿Por qué?
- ¿Para qué sirve `session_regenerate_id(true)`?
- ¿Por qué el mensaje de error es el mismo si falla el usuario o la contraseña?

## 6. Pruebas que he hecho
| Prueba | Resultado esperado | Resultado obtenido |
|---|---|---|
| Entrar en tablon.php sin login | | |
| Login con contraseña mala | | |
| Aceptar la misma misión dos veces | | |
| Cerrar sesión y volver al zurrón | | |
| Cambiar el tema y cerrar sesión | | |

## 7. Dificultades y cómo las he resuelto
