<header>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <title>Ultimos Formularios</title>
</header>
<?php

include 'menu.php';
// Tu código de conexión a la base de datos y otras configuraciones necesarias

// Consulta SQL
$sql = "SELECT * FROM `formulario_contacto` ORDER BY `formulario_contacto`.`ID` DESC limit 10 ";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Comienza la tabla con estilos CSS
    echo '<div class="content">';
    echo '<h1>Ultimos Formularios de Contacto</h1>';
    echo '<div class="table-container">';
    echo '<table class="styled-table">';
    // Encabezados de la tabla con estilos CSS
    echo '<thead><tr><th>Nombre</th><th>Email</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th><th>Estado</th><th style="text-align:center">Acciones</th></tr></thead>';
    echo '<tbody>';

    // Iterar sobre los resultados y mostrarlos en la tabla
    while ($row = $resultado->fetch_assoc()) {
        $id = $row["ID"];
        echo '<tr>';
        echo '<td>' . $row["Nombre"] . '</td>';
        echo '<td>' . $row["Correo"] . '</td>';
        echo '<td>' . $row["Fono"] . '</td>';
        echo '<td>' . $row["Mensaje"] . '</td>';
        echo '<td>' . $row["Fecha_Formulario"] . '</td>';

        // Verificar el estado y agregar clase CSS condicionalmente
        $estado_clase = $row["Estado"] == "Faltante" ? "estado-rojo" : "estado-verde";
        echo '<td class="' . $estado_clase . '">' . $row["Estado"] . '</td>';
        echo '<td style="text-align:center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal' . $row["ID"] . '">
            Registrar
            </button>
          
        <a class="email-link" href="mailto:' . $row["Correo"] . '?subject=Respuesta de APSIV.CL" target="_blank"><i class="fa-regular fa-paper-plane"></i> Enviar correo</a>
        </td>';
        include('modal_editar.php');

        echo '</tr>';
    }

    echo '</tbody>';
    // Cierra la tabla con estilos CSS
    echo '</table>';
    echo '</div>';
    echo '</div>';
} else {
    echo "No se encontraron resultados en la base de datos.";
}

// Cerrar la conexión a la base de datos u otros procesos de limpieza necesarios
$conexion->close();
?>
<!-- Button trigger modal -->


<!-- Modal -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>