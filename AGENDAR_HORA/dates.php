<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario del día</title>
    <style>
        * {
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        }

        .day-schedule {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #111D13;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            max-width: 600px;
            margin: 0 auto 20px;
            /* Centra horizontalmente y agrega margen inferior */
            text-align: center;
        }

        @media (max-width: 600px) {
            .day-schedule {
                max-width: 100%;
            }
        }


        .day-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
            text-transform: capitalize;
            background-color: #3E6680;
            color: white;
            height: 40px;
            line-height: 40px;

        }

        .time-slot {
            border: 2px solid #027BCE;
            /* Cambiar a la propiedad border */
            padding: 10px;
            border-radius: 10px;
            width: 100px;
            text-align: center;
            margin: 5px;
        }


        a {
            text-decoration: none;
            color: #111D13;
        }


        h1 {
            text-align: center;
            margin-bottom: 20px;
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

    include '../bd.php';
    /*
    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `formulario_contacto` WHERE ID=$id_registros";
        $conn->exec($sql);
        echo $sql . "<br>";
        $conn = null;
    } catch (PDOException $e) {
        $conn = null;
    }
        */

    function formatearFecha($fecha)
    {
        $fecha_objeto = new DateTime($fecha);
        $nombre_dia = $fecha_objeto->format('l'); // Nombre del día de la semana
        $nombre_mes = $fecha_objeto->format('F'); // Nombre del mes
        $traducciones = array(
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miercoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sabado',
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

    // Función para generar ranuras de tiempo
    function generarRanuras($inicio, $fin, $intervalo)
    {
        for ($hora = $inicio; $hora < $fin; $hora += $intervalo) {
            echo '<div class="time-slot">' . date('H:i', $hora) . '</div>';
        }
    }

    // Consulta SQL para obtener las fechas de la tabla correspondiente (limitando a 5 fechas)
    $sql = "SELECT * FROM disponibilidad WHERE dia >= NOW() LIMIT 5;";

    // Ejecutar la consulta
    $resultado = $conexion->query($sql);

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        // Iterar sobre los resultados y mostrar las fechas
        echo "<h1>Eliga su Hora</h1>";
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
?>
                    <form id="form-<?php echo $fila['dia'] . '-' . $bloque; ?>" action="confirmation.php" method="post" style="display: none;">
                        <input type="hidden" name="fecha" value="<?php echo $fila["dia"]; ?>">
                        <input type="hidden" name="bloque" value="<?php echo $bloque; ?>">
                        <input type="hidden" name="rut" value="<?php echo $rut; ?>">
                        <input type="hidden" name="isapre" value="<?php echo $isapre; ?>">
                    </form>
                    <a href="#" onclick="submitForm('form-<?php echo $fila['dia'] . '-' . $bloque; ?>');" class="enlace-bloque">
                        <script>
                            function submitForm(formId) {
                                document.getElementById(formId).submit();
                            }
                        </script>
    <?php
                    // Generar las ranuras de tiempo
                    generarRanuras(strtotime($inicio), strtotime($fin), 3600);
                    echo '</a>';
                }
            }

            echo '</div>';
        }
    } else {
        echo "<br><br><br><h1>No hay disponibilidad actualmente. Intente mas tarde</h1>";
    }

    $conexion->close();
} else {
    header('Location: ./');
    exit(); // Es importante terminar el script después de enviar el encabezado de redirección
}


echo '</body>'; // Cierre del div 'day-schedule'
// Cerrar la conexión

    ?>




</html>