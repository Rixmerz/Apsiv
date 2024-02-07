<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php

include 'bd.php';

date_default_timezone_set('America/Santiago');
$fecha_hora_actual = date('Y-m-d H:i:s');

$nombre  = $_REQUEST['nombre_contacto'];
$fono    = $_REQUEST['fono_contacto'];
$email   = $_REQUEST['email_contacto'];
$mensaje = $_REQUEST['mensaje_contacto'];


try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `formulario_contacto` (`Nombre`, `Correo`, `Fono`, `Mensaje`, `Fecha_Formulario`) VALUES (
'" . $nombre . "','" . $email . "','" . $fono . "','" . $mensaje . "','" . $fecha_hora_actual . "')";
    $conn->exec($sql);
    //echo $sql . "<br>";
    $conn = null;
} catch (PDOException $e) {
    $conn = null;
}

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
              window.location.href = "./";
            }, 100);
            break;
        }
      });
  </script>';;


?>