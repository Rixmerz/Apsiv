<!-- generar_pdf.php -->

<?php
// Recibir datos del formulario
$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];

// Llamar al script de Python para generar PDF
$command = escapeshellcmd('script.py ' . $nombre . ' ' . $cantidad);
$output = shell_exec($command);

if ($output === null) {
    echo "Se produjo un error al ejecutar el comando.";
} elseif (empty($output)) {
    echo "El comando se ejecutó correctamente, pero no se recibió ninguna salida.";
} else {
    echo "El comando se ejecutó correctamente. Salida: " . $output;
}
?>