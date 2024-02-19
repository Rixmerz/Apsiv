<header>
   <link rel="stylesheet" href="style.css">
</header>
<?php
include '../bd.php';
// Tu código de conexión a la base de datos y otras configuraciones necesarias

// Consulta SQL
$sql = "SELECT * FROM `formulario_contacto`";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Comienza la tabla con estilos CSS
    echo '<table class="styled-table">';
    // Encabezados de la tabla con estilos CSS
    echo '<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th></tr></thead>';
    echo '<tbody>';

    // Iterar sobre los resultados y mostrarlos en la tabla
    while ($row = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["ID"] . '</td>';
        echo '<td>' . $row["Nombre"] . '</td>';
        echo '<td>' . $row["Correo"] . '</td>';
        echo '<td>' . $row["Fono"] . '</td>';
        echo '<td>' . $row["Mensaje"] . '</td>';
        echo '<td>' . $row["Fecha_Formulario"] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    // Cierra la tabla con estilos CSS
    echo '</table>';
} else {
    echo "No se encontraron resultados en la base de datos.";
}

// Cerrar la conexión a la base de datos u otros procesos de limpieza necesarios
$conexion->close();
