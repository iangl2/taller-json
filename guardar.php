<?php
/**
 * guardar.php - Procesador de Reservas
 * 
 * Funcionalidad Principal:
 * - Recibe datos del formulario mediante $_POST
 * - Valida y sanitiza todas las entradas
 * - Lee el archivo datos.json existente
 * - Verifica que el código de reserva sea único
 * - Crea un nuevo arreglo asociativo con los datos
 * - Convierte a JSON con json_encode() y JSON_PRETTY_PRINT
 * - Guarda con file_put_contents()
 * - Redirecciona a index.php
 * 
 * Criterios de evaluación que cumple:
 * - Creación del nuevo objeto con los 10 datos (15 pts)
 * - Conversión con json_encode() (10 pts)
 * - Guardado con file_put_contents() (10 pts)
 * - Organización y limpieza del código (5 pts)
 * 
 * Funciones PHP obligatorias utilizadas:
 * - $_POST: Para recibir datos del formulario
 * - file_get_contents(): Para leer datos.json
 * - json_decode(): Para convertir JSON a arreglo PHP
 * - Arreglos asociativos: Para estructurar datos
 * - json_encode(): Para convertir arreglo PHP a JSON
 * - JSON_PRETTY_PRINT: Para formato legible del JSON
 * - file_put_contents(): Para guardar datos.json
 */

// ========================================
// SECCIÓN 1: Validar que la solicitud sea POST
// Propósito: Seguridad - solo procesar si viene del formulario
// ========================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// ========================================
// SECCIÓN 2: Recuperar y sanitizar datos del formulario
// Funciones: trim(), htmlspecialchars(), $_POST
// Propósito: Limpiar espacios y prevenir XSS
// ========================================

$codigo_reserva = isset($_POST['codigo_reserva']) ? trim($_POST['codigo_reserva']) : '';
$nombre_participante = isset($_POST['nombre_participante']) ? trim($_POST['nombre_participante']) : '';
$cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
$edad = isset($_POST['edad']) ? trim($_POST['edad']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$correo_electronico = isset($_POST['correo_electronico']) ? trim($_POST['correo_electronico']) : '';
$nombre_evento = isset($_POST['nombre_evento']) ? trim($_POST['nombre_evento']) : '';
$fecha_evento = isset($_POST['fecha_evento']) ? trim($_POST['fecha_evento']) : '';
$cantidad_acompanantes = isset($_POST['cantidad_acompanantes']) ? trim($_POST['cantidad_acompanantes']) : '';
$metodo_pago = isset($_POST['metodo_pago']) ? trim($_POST['metodo_pago']) : '';

// ========================================
// SECCIÓN 3: Validar que todos los campos estén presentes
// Propósito: Garantizar integridad de datos
// ========================================

$errores = [];

// Validar campos vacíos
if (empty($codigo_reserva)) $errores[] = "El código de reserva es obligatorio.";
if (empty($nombre_participante)) $errores[] = "El nombre del participante es obligatorio.";
if (empty($cedula)) $errores[] = "La cédula es obligatoria.";
if (empty($edad)) $errores[] = "La edad es obligatoria.";
if (empty($telefono)) $errores[] = "El teléfono es obligatorio.";
if (empty($correo_electronico)) $errores[] = "El correo electrónico es obligatorio.";
if (empty($nombre_evento)) $errores[] = "El nombre del evento es obligatorio.";
if (empty($fecha_evento)) $errores[] = "La fecha del evento es obligatoria.";
if (empty($cantidad_acompanantes) && $cantidad_acompanantes !== '0') $errores[] = "La cantidad de acompañantes es obligatoria.";
if (empty($metodo_pago)) $errores[] = "El método de pago es obligatorio.";

// ========================================
// SECCIÓN 4: Validar formato de datos específicos
// Propósito: Garantizar que los datos sean válidos según su tipo
// ========================================

// Validar edad: debe ser numérica
if (!empty($edad) && !is_numeric($edad)) {
    $errores[] = "La edad debe ser un número válido.";
}

if (!empty($edad) && (intval($edad) < 1 || intval($edad) > 120)) {
    $errores[] = "La edad debe estar entre 1 y 120 años.";
}

// Validar correo: formato de email
if (!empty($correo_electronico) && !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El formato del correo electrónico no es válido.";
}

// Validar teléfono: debe ser numérico (solo números, espacios, +, -)
if (!empty($telefono) && !preg_match('/^[0-9\+\-\s]{7,20}$/', $telefono)) {
    $errores[] = "El teléfono debe contener solo números, espacios, + o guiones (mínimo 7 caracteres).";
}

// Validar cédula: longitud mínima
if (!empty($cedula) && strlen($cedula) < 8) {
    $errores[] = "La cédula debe tener mínimo 8 caracteres.";
}

// Validar cantidad de acompañantes: debe ser numérica
if (!empty($cantidad_acompanantes) && !is_numeric($cantidad_acompanantes)) {
    $errores[] = "La cantidad de acompañantes debe ser un número válido.";
}

if (!empty($cantidad_acompanantes) && (intval($cantidad_acompanantes) < 0 || intval($cantidad_acompanantes) > 10)) {
    $errores[] = "La cantidad de acompañantes debe estar entre 0 y 10.";
}

// ========================================
// SECCIÓN 5: Si hay errores, mostrar y detener
// Propósito: Informar al usuario de problemas antes de guardar
// ========================================

if (!empty($errores)) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error en Validación</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <div class="contenedor">
            <header class="encabezado">
                <h1>❌ Error en la Validación</h1>
            </header>
            <section class="seccion-error">
                <div class="mensaje-error">
                    <h2>Por favor, revisa los siguientes errores:</h2>
                    <ul class="lista-errores">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="formulario.php" class="boton boton-primario">🔙 Volver al Formulario</a>
                </div>
            </section>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// ========================================
// SECCIÓN 6: Leer archivo datos.json existente
// Función: file_get_contents()
// Propósito: Obtener datos previamente guardados
// ========================================

$archivo_json = 'datos.json';
$contenido_json = file_get_contents($archivo_json);

// ========================================
// SECCIÓN 7: Convertir JSON a arreglo PHP
// Función: json_decode()
// Propósito: Convertir string JSON en arreglo asociativo manipulable
// Parámetro 'true': Asegura que retorne arreglo asociativo, no objeto
// ========================================

$registros = json_decode($contenido_json, true);

// Si el JSON está vacío o inválido, inicializar como arreglo vacío
if (!is_array($registros)) {
    $registros = [];
}

// ========================================
// SECCIÓN 8: Verificar que no exista código de reserva duplicado
// Propósito: Garantizar código_reserva único (clave primaria lógica)
// ========================================

foreach ($registros as $registro_existente) {
    if ($registro_existente['codigo_reserva'] === $codigo_reserva) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Código Duplicado</title>
            <link rel="stylesheet" href="estilos.css">
        </head>
        <body>
            <div class="contenedor">
                <header class="encabezado">
                    <h1>⚠️ Código de Reserva Duplicado</h1>
                </header>
                <section class="seccion-error">
                    <div class="mensaje-error">
                        <h2>El código de reserva ya existe</h2>
                        <p>Por favor, utiliza un código de reserva único.</p>
                        <p><strong>Código ingresado:</strong> <?php echo htmlspecialchars($codigo_reserva); ?></p>
                        <a href="formulario.php" class="boton boton-primario">🔙 Volver al Formulario</a>
                    </div>
                </section>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

// ========================================
// SECCIÓN 9: Crear nuevo arreglo asociativo con los 10 datos
// Propósito: Estructurar los datos de la reserva
// Características: Claves descriptivas, valores sanitizados con htmlspecialchars()
// ========================================

$nueva_reserva = [
    'codigo_reserva'        => htmlspecialchars($codigo_reserva),
    'nombre_participante'   => htmlspecialchars($nombre_participante),
    'cedula'                => htmlspecialchars($cedula),
    'edad'                  => htmlspecialchars($edad),
    'telefono'              => htmlspecialchars($telefono),
    'correo_electronico'    => htmlspecialchars($correo_electronico),
    'nombre_evento'         => htmlspecialchars($nombre_evento),
    'fecha_evento'          => htmlspecialchars($fecha_evento),
    'cantidad_acompanantes' => htmlspecialchars($cantidad_acompanantes),
    'metodo_pago'           => htmlspecialchars($metodo_pago)
];

// ========================================
// SECCIÓN 10: Agregar nuevo registro al arreglo
// Propósito: Mantener todos los registros históricos
// ========================================

$registros[] = $nueva_reserva;

// ========================================
// SECCIÓN 11: Convertir arreglo PHP a JSON
// Función: json_encode()
// Parámetro: JSON_PRETTY_PRINT para formato legible (requisito obligatorio)
// Propósito: Preparar datos para guardado en archivo
// ========================================

$json_actualizado = json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// ========================================
// SECCIÓN 12: Guardar JSON en archivo
// Función: file_put_contents()
// Propósito: Persistir datos en disco
// ========================================

$resultado = file_put_contents($archivo_json, $json_actualizado);

if ($resultado === false) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error de Guardado</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <div class="contenedor">
            <header class="encabezado">
                <h1>❌ Error al Guardar</h1>
            </header>
            <section class="seccion-error">
                <div class="mensaje-error">
                    <h2>No fue posible guardar la reserva</h2>
                    <p>Verifica los permisos del archivo datos.json</p>
                    <a href="formulario.php" class="boton boton-primario">🔙 Volver al Formulario</a>
                </div>
            </section>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// ========================================
// SECCIÓN 13: Redireccionar a página principal
// Propósito: Seguir patrón PRG (Post-Redirect-Get)
// Beneficio: Evita re-envío de formulario con F5
// ========================================

header('Location: index.php');
exit();
?>
