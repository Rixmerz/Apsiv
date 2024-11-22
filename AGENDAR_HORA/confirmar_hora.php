<!--coment
<header>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>
-->
<?php


// Función para formatear la fecha en español
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include '../bd.php';
  // Establecer la zona horaria a Santiago de Chile
  date_default_timezone_set('America/Santiago');

  // Obtener la fecha y hora actual
  $fecha_hora_actual = date('Y-m-d H:i:s');

  $fecha_sesion  = $_POST['fecha'];
  $bloque_sesion    = $_POST['bloque'];
  $rut_cliente   = $_POST['rut'];
  $isapre = $_POST['isapre'];

  echo $fecha_sesion . "<br>";
  echo $bloque_sesion . "<br>";
  echo $rut_cliente . "<br>";
  echo $isapre . "<br>";


  // VERIFICAR SI EXISTE EL PACIENTE EN LA BASE DE DATOS
  $cliente = $conexion->query("SELECT * FROM `pacientes` WHERE rut='$rut_cliente'");
  if ($mostrar = mysqli_fetch_assoc($cliente)) {
    $nombre1    = $mostrar['nombre_completo'];
    $id_cliente = $mostrar['ID'];
    echo "Paciente ya ingresado<br>";
    echo "$nombre1<br>$id_cliente<br>";
  } else {
    // INSERTAR DATOS EN CLIENTES
    $sql = "INSERT INTO `pacientes` (`rut`) VALUES ('$rut_cliente')";
    if (mysqli_query($conexion, $sql)) {
      $id_cliente = mysqli_insert_id($conexion);
      //echo "$sql<br>$id_cliente<br>";
    } else {
      // Manejar errores si es necesario
    }
  }

  // VERIFICAR LA DISPONIBILIDAD DE LA FECHA EN LA BASE DE DATOS
  $fecha = $conexion->query("SELECT * from disponibilidad where dia='$fecha_sesion' and $bloque_sesion='NO'");
  if ($fecha->num_rows > 0) {
    if ($mostrar = mysqli_fetch_assoc($fecha)) {
      $id_disponibilidad = $mostrar['id'];
      echo "Fecha  y hora disponible <br>";
      echo "$id_disponibilidad<br>";
    }
    //$update_sesion = $conexion->query("UPDATE disponibilidad SET $bloque_sesion ='SI' where id='$id_disponibilidad';");
  } else {
    echo "Fecha  y hora ocupada<br>";
    echo "Error";
    exit;
  }

  if ($id_disponibilidad != NULL) {


    // Definir los bloques horarios
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
    // Iterar sobre los bloques horarios
    foreach ($bloques_horarios as $bloque => $horario) {
      // Separar la hora de inicio y fin del horario
      list($inicio, $fin) = explode('-', $horario);


      echo $bloque . "<br>";
      echo $inicio . "<br>";
      echo $fin . "<br>";

      // Verificar si la hora de la sesión coincide con el bloque horario actual
      if ($bloque_sesion == $bloque) {
        $fecha_inicio = $fecha_sesion . " " . $inicio;
        $fecha_fin = $fecha_sesion . " " . $fin;

        try {
          $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $sql = "INSERT INTO `sesiones`( `ID_Paciente`, `Estado_Pago`, `Fecha_Sesion`,`Hora_Sesion`) VALUES 
                  ('$id_cliente','Faltante','$fecha_inicio','$fecha_fin')";
          //$conn->exec($sql);
          echo $sql . "<br>";
          $conn = null;
          echo '<script>
            Swal.fire({
                title: "Solicitud enviada correctamente!",
                text:"Se comunicaran con usted lo mas pronto posible",
                icon: "success",
                confirmButtonText: "OK",
              })
          
              .then((value) => {
                switch (value) {
                  default:
                    setTimeout(function() {
                      window.location.href = "../";
                    }, 100);
                    break;
                }
              });
          </script>';
        } catch (PDOException $e) {
          $conn = null;
        }
      }
    }
  }
} else {
  header('Location: ./');
  exit(); // Es importante terminar el script después de enviar el encabezado de redirección
}
