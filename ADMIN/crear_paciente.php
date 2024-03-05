<?php
include '../bd.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $id_registros = $_POST["id"];
    $nombre_paciente = $_POST["nombre_paciente"];
    $rut_paciente = $_POST["rut_paciente"];
    $correo_paciente = $_POST["correo_paciente"];
    $fono_paciente = $_POST["fono_paciente"];
    $fecha_paciente = $_POST["fecha_paciente"];
    $notas_paciente = $_POST["notas_paciente"];

    // Prepara la consulta SQL para insertar el evento en la base de datos
    $sql_insert = "INSERT INTO `pacientes`(`nombre_completo`, `rut`, `correo`, `fono`, `fecha_nacimiento`, `notas`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("ssssss", $nombre_paciente, $rut_paciente, $correo_paciente, $fono_paciente, $fecha_paciente, $notas_paciente);

    // Prepara la consulta SQL para eliminar el registro existente
    $sql_delete = "DELETE FROM `formulario_contacto` WHERE ID=?";
    $stmt_delete = $conexion->prepare($sql_delete);
    $stmt_delete->bind_param('i', $id_registros);

    // Inicia una transacción
    $conexion->begin_transaction();

    // Ejecuta la inserción y la eliminación en una transacción
    $insercion_exitosa = $stmt_insert->execute();
    $eliminacion_exitosa = $stmt_delete->execute();

    // Verifica si ambas consultas fueron exitosas
    if ($insercion_exitosa && $eliminacion_exitosa) {
        // Confirma la transacción si ambas consultas se ejecutan con éxito
        $conexion->commit();
        echo "Datos insertados y registro eliminado exitosamente.";
    } else {
        // Revierte la transacción si alguna consulta falla
        $conexion->rollback();
        echo "Error al insertar datos o eliminar registro.";
    }

    // Cierra los statements
    $stmt_insert->close();
    $stmt_delete->close();

    header("Location: index.php");
    exit;
}
