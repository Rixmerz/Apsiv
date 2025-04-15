

<?php

include 'bd.php';

date_default_timezone_set('America/Santiago');
$fecha_hora_actual = date('Y-m-d H:i:s');

$nombre  = $_POST['nombre_contacto'];
$fono    = $_POST['fono_contacto'];
$email   = $_POST['email_contacto'];
$mensaje = $_POST['mensaje_contacto'];

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
  echo "¡Datos guardados correctamente!";
} catch (PDOException $e) {
  echo "Error al guardar los datos: " . $e->getMessage();
}

?>