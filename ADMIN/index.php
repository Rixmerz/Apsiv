<?php
include '../bd.php'; // Incluye el archivo de conexión a la base de datos

// Prepara la consulta SQL para obtener los eventos de la base de datos
$sql = "SELECT sesiones.* ,pacientes.nombre_completo FROM `sesiones` INNER JOIN `pacientes` ON sesiones.ID_Paciente = pacientes.ID;";
$resultado = $conexion->query($sql);

$eventos = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $eventos[] = [
            'title' => $fila['nombre_completo'] . " - " . $fila['Detalle'],
            'start' => $fila['Fecha_Sesion'],
            'end' => $fila['Hora_Sesion']
        ];
    }
}
include 'menu.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="agenda.css?v=<?php echo time(); ?>">
    <script src="../JS/locales-all.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var initialLocaleCode = 'es';
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?php echo json_encode($eventos); ?>,
                locale: initialLocaleCode,
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                dayMaxEvents: true, // allow "more" link when too many events
                selectable: true,
                select: function(info) {
                    var fechaSeleccionada = document.getElementById('inputCita');
                    fechaSeleccionada.value = info.startStr; // Acceder a info.startStr en lugar de info.dateStr
                }
            });

            calendar.render();
        });
    </script>

</head>

<body>

    <!-- AGENDA lateral -->
    <div class="derecha">
        <h4 class="text-center">Lista de Próximas Reuniones</h4>
        <div class="agenda-slider">


            <?php

            function formatearFecha($fecha)
            {
                $fecha_objeto = new DateTime($fecha);
                $nombre_dia = $fecha_objeto->format('l'); // Nombre del día de la semana
                $nombre_mes = $fecha_objeto->format('F'); // Nombre del mes
                $traducciones = array(
                    'Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves',
                    'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo',
                    'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo', 'April' => 'Abril',
                    'May' => 'Mayo', 'June' => 'Junio', 'July' => 'Julio', 'August' => 'Agosto', 'September' => 'Septiembre',
                    'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
                );
                $nombre_dia = $traducciones[$nombre_dia];
                $nombre_mes = $traducciones[$nombre_mes];
                $numero_dia = $fecha_objeto->format('j');
                $hora = $fecha_objeto->format('h:i A'); // Hora en formato AM/PM
                return "$hora,$nombre_dia $numero_dia de $nombre_mes";
            }


            $sql = "SELECT sesiones.*, pacientes.nombre_completo FROM sesiones INNER JOIN pacientes ON sesiones.ID_Paciente = pacientes.ID WHERE Fecha_Sesion >= CURRENT_DATE ORDER BY `sesiones`.`Fecha_Sesion` ASC;";
            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()) {
                $fecha = $fila['Fecha_Sesion'];
                $fecha_formateada = formatearFecha($fecha);

                echo "<div class='agenda-item'>";
                echo "<h5>Paciente : " . $fila['nombre_completo'] . "  </h5>";
                echo "<p>" . $fecha_formateada . "</p>";
                echo "<p>Detalles: " . $fila['Detalle'] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    </div>

    <!-- Contenido principal -->

    <div class="text-center mb-4 abajo">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModal">
            Nueva Sesion
        </button>
    </div>
    <div id='calendar'></div>

    <!-- Modal -->
    <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Cita</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="infoForm" action="crear_sesion.php" method="POST">
                        <div class="form-group">
                            <label for="fecha_sesion" class="col-form-label">Fecha de la Sesion:</label>
                            <input type="date" name="fecha_sesion" min="<?php echo date('Y-m-d'); ?>" id="inputCita" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="hora_sesion" class="col-form-label">
                                Hora de la Sesion:
                            </label>
                            <select type="text" name="hora_sesion" id="hora_sesion" class="form-control" required>
                                <option value="">Seleccione Hora </option>
                                <option value="Bloque_1">09:00 - 10:00</option>
                                <option value="Bloque_2">10:00 - 11:00</option>
                                <option value="Bloque_3">11:00 - 12:00</option>
                                <option value="Bloque_4">12:00 - 13:00</option>
                                <option value="Bloque_5">14:00 - 15:00</option>
                                <option value="Bloque_6">15:00 - 16:00</option>
                                <option value="Bloque_7">16:00 - 17:00</option>
                                <option value="Bloque_8">17:00 - 18:00</option>
                            </select>
                            <!--
                            <input type="text" name="hora_sesion" id="hora_sesion" list="horas" class="form-control" required>
                            <datalist id="horas">
                                <?php
                                $horas = $conexion->query("SELECT * FROM `disponibilidad` where dia='2024-03-06';");

                                foreach ($horas as $hora) {
                                    echo "<option value='" . $hora['Bloque_1'] . "'></option>";
                                }

                                ?>
                            </datalist>
                            -->

                        </div>
                        <div class="form-group">
                            <label for="nombre_paciente" class="col-form-label">
                                Nombre del Paciente:
                            </label>
                            <input type="text" name="nombre_paciente" id="nombre" list="nombres" class="form-control" required>
                            <datalist id="nombres">
                                <?php
                                $nombres = $conexion->query("SELECT DISTINCT nombre_completo FROM `pacientes`;");

                                foreach ($nombres as $nombre) {
                                    echo "<option value='" . $nombre['nombre_completo'] . "'></option>";
                                }

                                ?>
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="detalles_paciente" class="col-form-label">Detalles:</label>
                            <textarea id="detalles_paciente" name="detalles_paciente" rows="4" cols="50" class="form-control"></textarea><br>
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Sesion</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector(".sidebar");
            var content = document.querySelector(".content");
            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-250px";
                content.style.marginLeft = "0px"; /* Oculta el menú si está visible */
            } else {
                sidebar.style.left = "0";
                content.style.marginLeft =
                    "250px"; /* Muestra el menú si está oculto */
            }
        }
    </script>
</body>

</html>