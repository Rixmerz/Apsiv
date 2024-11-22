<?php
include 'menu.php';
include '../bd.php';


try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE `formulario_contacto` SET `Estado_Visto`='Visto';";
    $conn->exec($sql);
    //echo $sql . "<br>";
    $conn = null;
} catch (PDOException $e) {
    $conn = null;
}
?>

<header>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <title>Ultimos Formularios</title>
</header>

<div class="contenido" style="display: flex; justify-content: flex-end;">
    <?php
    // Consulta SQL para obtener la disponibilidad del día actual
    $sql3 = "SELECT * FROM `disponibilidad` WHERE dia = CURDATE()";

    // Ejecutar la consulta
    $resultado_dias = $conexion->query($sql3);

    // Verificar si la consulta fue exitosa
    if ($resultado_dias) {
        // Verificar si no hay registros de disponibilidad para el día actual
        if ($resultado_dias->num_rows == 0) {
    ?>
            <!-- Botón para crear fechas legales si no hay disponibilidad -->
            <button type="button" class="btn btn-secondary" onclick="window.location.href='./crear_fechas_legales.php'">
                Crear fechas legales
            </button>
    <?php
        }
    } else {
        // Mostrar un mensaje de error si la consulta falla
        echo "Error al ejecutar la consulta: " . $conexion->error;
    }
    ?>
</div>

<?php
// Consulta SQL
$sql = "SELECT * FROM `formulario_contacto` ORDER BY `formulario_contacto`.`ID` DESC limit 10 ";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Comienza la tabla con estilos CSS
    echo '<div class="content">';
    echo '<h1 style="margin-bottom:20px">Ultimos Formularios de Contacto</h1>';
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
            <button type="button" class="btn btn-primary w-75" data-bs-toggle="modal" data-bs-target="#exampleModal' . $row["ID"] . '">
            Registrar
            </button><br>';

        $sql2 = "SELECT * FROM `tokens` where ID_Formulario='$id' AND Fecha_Expiracion > NOW();";
        $consulta = $conexion->query($sql2);
        //echo $sql2."<br>";

        // Verificar si se obtuvieron resultados
        if ($consulta->num_rows > 0) {
            echo '
                <button type="button" class="btn btn-secondary w-75" data-bs-toggle="modal" data-bs-target="#ModalToken' . $row["ID"] . '">
                Ver Token
                </button>';
        } else {
            echo '
                <button type="button" class="btn btn-secondary w-75" data-bs-toggle="modal" data-bs-target="#ModalToken' . $row["ID"] . '">
                Crear Token
                </button>';
        }

        echo '

            <br>
              <button type="button" class="btn btn-danger w-75" data-bs-toggle="modal" data-bs-target="#ModalDelete' . $row["ID"] . '">
            Eliminar Consulta
            </button><br>
            <a class="email-link w-75" href="mailto:' . $row["Correo"] . '?subject=Respuesta de APSIV.CL" target="_blank"><i class="fa-regular fa-paper-plane"></i> Enviar correo</a>
        </td>';
        include('modal_editar.php');
        include('modal_token.php');
        include('modal_delete.php');

        echo '</tr>';
    }

    echo '</tbody>';
    // Cierra la tabla con estilos CSS
    echo '</table>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="content">';
    echo "No se encontraron resultados en la base de datos.";
    echo '</div>';
}

// Cerrar la conexión a la base de datos u otros procesos de limpieza necesarios
$conexion->close();
?>
<!-- Button trigger modal -->


<!-- Modal -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>