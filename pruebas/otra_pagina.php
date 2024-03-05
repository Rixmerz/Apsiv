<?php
// Recuperar los valores de la fecha y el bloque
$fecha = $_GET['fecha'];
$bloque = $_GET['bloque'];

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

// Obtener el horario correspondiente al bloque seleccionado
$horario = $bloques_horarios[$bloque];

// Hacer lo que necesites con los valores recuperados
echo "Fecha: " . formatearFecha($fecha) . "<br>";
//echo "Bloque: " . $bloque . "<br>";
echo "Horario: " . $horario;
