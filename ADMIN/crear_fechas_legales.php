<?php
// Primer día del mes actual
$primer_dia_mes = date('Y-m-01');
// Último día del mes actual
$ultimo_dia_mes = date('Y-m-t');

function calcularDiasHabiles($fechaInicio, $fechaFin)
{
    $diasHabiles = array();

    $fechaActual = new DateTime($fechaInicio);
    $fechaFin = new DateTime($fechaFin);

    while ($fechaActual <= $fechaFin) {
        $diaSemana = $fechaActual->format('N'); // Obtener el día de la semana (1 para lunes, 2 para martes, etc.)

        // Si el día de la semana no es sábado (6) ni domingo (7), lo agregamos a los días hábiles
        if ($diaSemana != 6 && $diaSemana != 7) {
            $diasHabiles[] = $fechaActual->format('Y-m-d');
        }

        // Avanzamos al siguiente día
        $fechaActual->modify('+1 day');
    }

    return $diasHabiles;
}

// Conexión a la base de datos
include '../bd.php';

// Rango de fechas
$fechaInicio = $primer_dia_mes;
$fechaFin = $ultimo_dia_mes;

// Calcular días hábiles en el rango de fechas
$diasHabiles = calcularDiasHabiles($fechaInicio, $fechaFin);

$fecha = $conexion->query("SELECT * from disponibilidad where dia='$fechaFin'");
if ($fecha->num_rows > 0) {
    if ($mostrar = mysqli_fetch_assoc($fecha)) {
        $id_disponibilidad = $mostrar['id'];
        echo "Fecha  y hora insertadas <br>";
    }
} else {
    // Insertar los días hábiles en la tabla de disponibilidad
    foreach ($diasHabiles as $dia) {
        $sql = "INSERT INTO disponibilidad (dia) VALUES ('$dia')";
        if ($conexion->query($sql) === false) {
            echo "Error al insertar el día " . $dia . ": " . $conexion->error . "<br>";
        }
    }
}


$conexion->close();

header("Location: index.php");
