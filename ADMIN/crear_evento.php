<?php
include './bd.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    // Prepara la consulta SQL para insertar el evento en la base de datos
    $sql = "INSERT INTO eventos (titulo, fecha_inicio, fecha_fin) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $titulo, $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $stmt->close();

    header("Location: agenda.php");
    exit;
}
