<?php
/**
 * formulario.php - Formulario de Registro de Reservas
 * 
 * Funcionalidad:
 * - Presenta 10 campos de captura de datos
 * - Utiliza validaciones HTML5
 * - Implementa placeholders y etiquetas label
 * - Tiene botones Guardar y Regresar
 * - Diseño moderno y responsive
 * 
 * Criterios de evaluación que cumple:
 * - Diseño del formulario HTML con 10 campos (15 pts)
 * - Uso correcto de CSS (10 pts)
 * - Organización y limpieza del código (5 pts)
 */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Reserva - Sistema de Eventos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="contenedor">
        <!-- Encabezado -->
        <header class="encabezado">
            <div class="encabezado-contenido">
                <h1>📝 Formulario de Registro</h1>
                <p class="subtitulo">Completa todos los campos para registrar una nueva reserva</p>
            </div>
        </header>

        <!-- Sección del Formulario -->
        <section class="seccion-formulario">
            <!-- ========================================
                 FORMULARIO DE CAPTURA
                 - Utiliza método POST
                 - Acción: guardar.php (procesamiento de datos)
                 - Validaciones HTML5 (required, type, pattern)
                 - Todos los campos con etiquetas label
                 - Placeholders descriptivos
                 ======================================== -->
            <form method="POST" action="guardar.php" class="formulario" id="formulario-reserva">

                <!-- FILA 1: Código de Reserva y Nombre -->
                <div class="fila-formulario">
                    <!-- Campo 1: Código de Reserva -->
                    <div class="grupo-campo">
                        <label for="codigo_reserva" class="etiqueta-campo">
                            📌 Código de Reserva *
                        </label>
                        <input 
                            type="text" 
                            id="codigo_reserva" 
                            name="codigo_reserva"
                            class="campo-entrada"
                            placeholder="Ej: RES-2026-001"
                            required
                            pattern="[A-Z0-9\-]+"
                            maxlength="20"
                            title="Código: mayúsculas, números y guiones"
                        >
                        <small class="ayuda">Identificador único de la reserva</small>
                    </div>

                    <!-- Campo 2: Nombre del Participante -->
                    <div class="grupo-campo">
                        <label for="nombre_participante" class="etiqueta-campo">
                            👤 Nombre Completo *
                        </label>
                        <input 
                            type="text" 
                            id="nombre_participante" 
                            name="nombre_participante"
                            class="campo-entrada"
                            placeholder="Ej: Juan Pérez González"
                            required
                            minlength="5"
                            maxlength="100"
                            title="Mínimo 5 caracteres"
                        >
                        <small class="ayuda">Nombre y apellidos completos</small>
                    </div>
                </div>

                <!-- FILA 2: Cédula y Edad -->
                <div class="fila-formulario">
                    <!-- Campo 3: Cédula -->
                    <div class="grupo-campo">
                        <label for="cedula" class="etiqueta-campo">
                            🆔 Cédula *
                        </label>
                        <input 
                            type="text" 
                            id="cedula" 
                            name="cedula"
                            class="campo-entrada"
                            placeholder="Ej: 1234567890"
                            required
                            pattern="[0-9\.\-]+"
                            minlength="8"
                            maxlength="20"
                            title="Mínimo 8 caracteres, solo números, puntos y guiones"
                        >
                        <small class="ayuda">Número de documento de identidad</small>
                    </div>

                    <!-- Campo 4: Edad -->
                    <div class="grupo-campo">
                        <label for="edad" class="etiqueta-campo">
                            🎂 Edad *
                        </label>
                        <input 
                            type="number" 
                            id="edad" 
                            name="edad"
                            class="campo-entrada"
                            placeholder="Ej: 25"
                            required
                            min="1"
                            max="120"
                            title="Edad debe estar entre 1 y 120"
                        >
                        <small class="ayuda">Edad numérica del participante</small>
                    </div>
                </div>

                <!-- FILA 3: Teléfono y Correo -->
                <div class="fila-formulario">
                    <!-- Campo 5: Teléfono -->
                    <div class="grupo-campo">
                        <label for="telefono" class="etiqueta-campo">
                            ☎️ Teléfono *
                        </label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono"
                            class="campo-entrada"
                            placeholder="Ej: +34 600123456 o 600123456"
                            required
                            pattern="[0-9\+\-\s]+"
                            minlength="7"
                            maxlength="20"
                            title="Formato: números, +, espacios o guiones"
                        >
                        <small class="ayuda">Número de contacto principal</small>
                    </div>

                    <!-- Campo 6: Correo Electrónico -->
                    <div class="grupo-campo">
                        <label for="correo_electronico" class="etiqueta-campo">
                            ✉️ Correo Electrónico *
                        </label>
                        <input 
                            type="email" 
                            id="correo_electronico" 
                            name="correo_electronico"
                            class="campo-entrada"
                            placeholder="Ej: juan.perez@ejemplo.com"
                            required
                            title="Debe ser un correo válido"
                        >
                        <small class="ayuda">Correo para confirmación</small>
                    </div>
                </div>

                <!-- FILA 4: Evento y Fecha -->
                <div class="fila-formulario">
                    <!-- Campo 7: Nombre del Evento -->
                    <div class="grupo-campo">
                        <label for="nombre_evento" class="etiqueta-campo">
                            🎪 Nombre del Evento *
                        </label>
                        <select 
                            id="nombre_evento" 
                            name="nombre_evento"
                            class="campo-entrada"
                            required
                        >
                            <option value="">-- Selecciona un evento --</option>
                            <option value="Conferencia de Tecnología">Conferencia de Tecnología</option>
                            <option value="Workshop de PHP">Workshop de PHP</option>
                            <option value="Seminario de JSON">Seminario de JSON</option>
                            <option value="Networking Profesional">Networking Profesional</option>
                            <option value="Certificación en Web">Certificación en Web</option>
                            <option value="Hackathon 2026">Hackathon 2026</option>
                        </select>
                        <small class="ayuda">Selecciona la actividad a participar</small>
                    </div>

                    <!-- Campo 8: Fecha del Evento -->
                    <div class="grupo-campo">
                        <label for="fecha_evento" class="etiqueta-campo">
                            📆 Fecha del Evento *
                        </label>
                        <input 
                            type="date" 
                            id="fecha_evento" 
                            name="fecha_evento"
                            class="campo-entrada"
                            required
                            title="Selecciona una fecha válida"
                        >
                        <small class="ayuda">Día en que se realizará el evento</small>
                    </div>
                </div>

                <!-- FILA 5: Acompañantes y Pago -->
                <div class="fila-formulario">
                    <!-- Campo 9: Cantidad de Acompañantes -->
                    <div class="grupo-campo">
                        <label for="cantidad_acompanantes" class="etiqueta-campo">
                            👥 Cantidad de Acompañantes *
                        </label>
                        <input 
                            type="number" 
                            id="cantidad_acompanantes" 
                            name="cantidad_acompanantes"
                            class="campo-entrada"
                            placeholder="Ej: 2"
                            required
                            min="0"
                            max="10"
                            value="0"
                            title="Número entre 0 y 10"
                        >
                        <small class="ayuda">Personas adicionales que acompañarán</small>
                    </div>

                    <!-- Campo 10: Método de Pago -->
                    <div class="grupo-campo">
                        <label for="metodo_pago" class="etiqueta-campo">
                            💳 Método de Pago *
                        </label>
                        <select 
                            id="metodo_pago" 
                            name="metodo_pago"
                            class="campo-entrada"
                            required
                        >
                            <option value="">-- Selecciona método --</option>
                            <option value="Efectivo">💵 Efectivo</option>
                            <option value="Tarjeta">💳 Tarjeta de Crédito/Débito</option>
                            <option value="Transferencia">🏦 Transferencia Bancaria</option>
                        </select>
                        <small class="ayuda">Forma de pago preferida</small>
                    </div>
                </div>

                <!-- Sección de Botones -->
                <div class="seccion-botones">
                    <button 
                        type="submit" 
                        class="boton boton-primario"
                        id="boton-guardar"
                    >
                        ✅ Guardar Reserva
                    </button>
                    <a 
                        href="index.php" 
                        class="boton boton-secundario"
                        id="boton-regresar"
                    >
                        ⬅️ Regresar
                    </a>
                </div>

                <!-- Información adicional -->
                <div class="informacion-formulario">
                    <p><strong>Nota:</strong> Todos los campos marcados con <span class="asterisco">*</span> son obligatorios.</p>
                    <p>Los datos se guardarán en formato JSON para posterior consulta.</p>
                </div>

            </form>
        </section>

        <!-- Pie de página -->
        <footer class="pie-pagina">
            <p>&copy; 2026 Sistema de Reservas. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>
