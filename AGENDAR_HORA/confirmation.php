<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Hora</title>
    <style>
        body {
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .confirmation-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .confirmation-container h2 {
            color: #3E6680;
            margin-bottom: 20px;
        }

        .confirmation-container p {
            margin: 10px 0;
        }

        .button-container {
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-container a,
        .button-container form input[type="submit"] {
            text-decoration: none;
            color: white;
            background-color: #027BCE;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container a:hover,
        .button-container form input[type="submit"]:hover {
            background-color: #025a9b;
        }

        .button-container .cancel-btn {
            background-color: #d9534f;
            margin-right: 30%;
        }

        .button-container .cancel-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<?php

// Función para formatear la fecha en español
if ($_SERVER["REQUEST_METHOD"] == "POST") {
?>

    <body>
        <div class="confirmation-container">
            <?php
            // Simulación de los datos recuperados para la confirmación (sustituye esto por los valores reales)
            $fecha = isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : '';
            $bloque = isset($_POST['bloque']) ? htmlspecialchars($_POST['bloque']) : '';
            $rut = isset($_POST['rut']) ? htmlspecialchars($_POST['rut']) : '';
            $isapre = isset($_POST['isapre']) ? htmlspecialchars($_POST['isapre']) : '';

            // Función para formatear la fecha en español
            function formatearFecha($fecha)
            {
                $fecha_objeto = new DateTime($fecha);
                $nombre_dia = $fecha_objeto->format('l'); // Nombre del día de la semana
                $nombre_mes = $fecha_objeto->format('F'); // Nombre del mes
                $traducciones = array(
                    'Monday' => 'Lunes',
                    'Tuesday' => 'Martes',
                    'Wednesday' => 'Miércoles',
                    'Thursday' => 'Jueves',
                    'Friday' => 'Viernes',
                    'Saturday' => 'Sábado',
                    'Sunday' => 'Domingo',
                    'January' => 'Enero',
                    'February' => 'Febrero',
                    'March' => 'Marzo',
                    'April' => 'Abril',
                    'May' => 'Mayo',
                    'June' => 'Junio',
                    'July' => 'Julio',
                    'August' => 'Agosto',
                    'September' => 'Septiembre',
                    'October' => 'Octubre',
                    'November' => 'Noviembre',
                    'December' => 'Diciembre'
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

            echo "<h2> ¿Desea confirmar su hora? </h2>";
            echo "<p>Fecha: " . formatearFecha($fecha) . "</p>";
            echo "<p>Horario: " . $horario . "</p>";
            echo "<p>Rut: " . $rut . "</p>";
            echo "<p>Isapre: " . $isapre . "</p>";
            ?>
            <div class="button-container">
                <form action="confirmar_hora.php" method="post">
                    <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                    <input type="hidden" name="bloque" value="<?php echo $bloque; ?>">
                    <input type="hidden" name="rut" value="<?php echo $rut; ?>">
                    <input type="hidden" name="isapre" value="<?php echo $isapre; ?>">

                    <a href="javascript:history.back()" class="cancel-btn">Cancelar</a>

                    <input type="submit" value="Confirmar">
                </form>

            </div>
        </div>
    </body>
<?php
} else {
    header('Location: ./');
    exit(); // Es importante terminar el script después de enviar el encabezado de redirección
}
?>

</html>