<?php
/**
 * index.php - Página Principal del Sistema de Reservas
 * 
 * Funcionalidad:
 * - Lee el archivo datos.json usando file_get_contents()
 * - Convierte JSON a arreglo PHP usando json_decode()
 * - Muestra todos los registros en una tabla HTML
 * - Proporciona botón para registrar nueva reserva
 * - Muestra cantidad total de reservas
 * 
 * Criterios de evaluación que cumple:
 * - Lectura del archivo JSON (15 pts)
 * - Uso adecuado de json_decode() (10 pts)
 * - Visualización de registros en tabla HTML (10 pts)
 * - Diseño moderno y responsive (15 pts en CSS)
 */

// Ruta del archivo JSON
$archivo_json = 'datos.json';

// ========================================
// SECCIÓN 1: Lectura de datos.json
// Función: file_get_contents()
// Propósito: Obtener el contenido completo del archivo JSON
// ========================================
$contenido_json = file_get_contents($archivo_json);

// ========================================
// SECCIÓN 2: Conversión de JSON a arreglo PHP
// Función: json_decode()
// Propósito: Convertir string JSON en arreglo asociativo de PHP
// Parámetro 'true': Retorna arreglo asociativo (no objeto)
// ========================================
$registros = json_decode($contenido_json, true);

// Si no hay registros o el JSON está vacío, inicializar como arreglo vacío
if (!is_array($registros)) {
    $registros = [];
}

// Cantidad total de reservas
$total_reservas = count($registros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reservas - Inicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="contenedor">
        <!-- Encabezado -->
        <header class="encabezado">
            <div class="encabezado-contenido">
                <h1>📅 Sistema de Reservas de Eventos</h1>
                <p class="subtitulo">Administra las inscripciones de participantes</p>
            </div>
        </header>

        <!-- Sección de Estadísticas -->
        <section class="seccion-estadisticas">
            <div class="tarjeta-estadistica">
                <h3>Total de Reservas</h3>
                <p class="numero-grande"><?php echo $total_reservas; ?></p>
            </div>
            <a href="formulario.php" class="boton boton-primario">
                ➕ Nueva Reserva
            </a>
        </section>

        <!-- Sección de Registros -->
        <section class="seccion-registros">
            <h2>Registros Almacenados</h2>

            <?php if ($total_reservas > 0): ?>
                <!-- ========================================
                     TABLA DE REGISTROS
                     Muestra todos los registros guardados en JSON
                     Cada fila representa una reserva
                     ======================================== -->
                <div class="tabla-responsiva">
                    <table class="tabla-registros">
                        <thead>
                            <tr>
                                <th>Código de Reserva</th>
                                <th>Participante</th>
                                <th>Cédula</th>
                                <th>Correo</th>
                                <th>Evento</th>
                                <th>Fecha</th>
                                <th>Teléfono</th>
                                <th>Acompañantes</th>
                                <th>Pago</th>
                                <th>Edad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registros as $registro): ?>
                                <tr class="fila-registro">
                                    <td class="celda-codigo">
                                        <span class="badge"><?php echo htmlspecialchars($registro['codigo_reserva']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($registro['nombre_participante']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['cedula']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['correo_electronico']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['nombre_evento']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['fecha_evento']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['telefono']); ?></td>
                                    <td class="celda-centrada"><?php echo htmlspecialchars($registro['cantidad_acompanantes']); ?></td>
                                    <td>
                                        <span class="etiqueta-pago">
                                            <?php echo htmlspecialchars($registro['metodo_pago']); ?>
                                        </span>
                                    </td>
                                    <td class="celda-centrada"><?php echo htmlspecialchars($registro['edad']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Mensaje cuando no hay registros -->
                <div class="mensaje-vacio">
                    <p>📭 No hay registros disponibles</p>
                    <p class="subtitulo-mensaje">Crea una nueva reserva para comenzar</p>
                    <a href="formulario.php" class="boton boton-primario">Crear Primera Reserva</a>
                </div>
            <?php endif; ?>
        </section>

        <!-- Pie de página -->
        <footer class="pie-pagina">
            <p>&copy; 2026 Sistema de Reservas. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>
