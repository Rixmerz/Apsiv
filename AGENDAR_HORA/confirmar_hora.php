<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>
<?php

include '../bd.php';


$nombre  = $_POST['fecha'];
$fono    = $_POST['bloque'];
$email   = $_POST['rut'];
$mensaje = $_POST['isapre'];

echo $token . "<br>";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `formulario_contacto` (`Nombre`, `Correo`, `Fono`, `Mensaje`, `Fecha_Formulario`) VALUES (
    :nombre, :email, :fono, :mensaje, :fecha)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':fono', $fono);
    $stmt->bindParam(':mensaje', $mensaje);
    $stmt->bindParam(':fecha', $fecha_hora_actual);
    $stmt->execute();
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
  </script>';
} catch (PDOException $e) {
    echo "Error al guardar los datos: " . $e->getMessage();
}
