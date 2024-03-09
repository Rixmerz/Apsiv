<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario del día</title>
    <style>
        .day-schedule {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            width: 600px;
            margin: 0 auto 20px;
            /* Centra horizontalmente y agrega margen inferior */
            text-align: center;
        }

        .day-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
            text-transform: capitalize;
        }

        .time-slot {
            background-color: #e0e0e0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            width: 100px;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<?php
echo '<body>';
// Función para formatear la fecha en español

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar el campo "rut"
    $rut = htmlspecialchars($_POST['rut']);
    // Obtener y sanitizar el campo "isapre"
    $isapre = htmlspecialchars($_POST['isapre']);

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
        return "$nombre_dia $numero_dia de $nombre_mes";
    }

    // Función para generar ranuras de tiempo
    function generarRanuras($inicio, $fin, $intervalo)
    {
        for ($hora = $inicio; $hora < $fin; $hora += $intervalo) {
            echo '<div class="time-slot">' . date('H:i', $hora) . '</div>';
        }
    }

    // Incluir archivo de configuración de la base de datos
    include '../bd.php';

    // Consulta SQL para obtener las fechas de la tabla correspondiente (limitando a 5 fechas)
    $sql = "SELECT * FROM disponibilidad WHERE dia >= CURDATE() limit 5";

    // Ejecutar la consulta
    $resultado = $conexion->query($sql);

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        // Iterar sobre los resultados y mostrar las fechas
        while ($fila = $resultado->fetch_assoc()) {
            // Div contenedor de la programación del día

            echo '<div class="day-schedule"><div class="day-title" id="dayTitle">';
            echo formatearFecha($fila["dia"]);
            echo '</div>';

            // Configurar los bloques de horarios
            $bloques_horarios = array(
                "Bloque_1" => "09:00-10:00",
                "Bloque_2" => "10:00-11:00",
                "Bloque_3" => "11:00-12:00",
                "Bloque_4" => "12:00-13:00",
                "Bloque_5" => "14:00-15:00",
                "Bloque_6" => "15:00-16:00",
                "Bloque_7" => "16:00-17:00",
                "Bloque_8" => "17:00-18:00"
            );

            foreach ($bloques_horarios as $bloque => $horario) {
                if ($fila[$bloque] != "SI") {
                    list($inicio, $fin) = explode('-', $horario);
                    // Generar la URL con los datos de la fecha y el bloque como parámetros de consulta
                    $url = "otra_pagina.php?fecha=" . urlencode($fila["dia"]) . "&bloque=" . urlencode($bloque) . "&rut=" . urlencode($rut) . "&isapre=" . urlencode($isapre);
                    // Imprimir el enlace <a> con el URL generado
                    echo '<a href="' . $url . '" class="enlace-bloque">';
                    // Generar las ranuras de tiempo
                    generarRanuras(strtotime($inicio), strtotime($fin), 3600);
                    echo '</a>';
                }
            }

            echo '</div>';
        }
    } else {
        echo "No se encontraron fechas en la base de datos.";
    }
}
echo '</body>'; // Cierre del div 'day-schedule'
// Cerrar la conexión
$conexion->close();
?>




</html>