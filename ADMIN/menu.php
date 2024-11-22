<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    // Si no tiene sesión iniciada o no es administrador, redirigirlo a la página de inicio de sesión
    header("location: ../login.php");
    unset($_SESSION['username']);
    session_destroy();
    exit(); // Terminar el script para evitar que el resto del código se ejecute
}

// El resto del código de la página de inicio de administrador aquí
include '../bd.php';
?>

<head>
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
</head>

<style>
    body {
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    }

    .sidebar {
        position: fixed;
        left: 0;
        /* Inicia oculto */
        top: 0;
        height: 100%;
        width: 250px;
        background-color: #333;
        padding-top: 60px;
        transition: left 0.3s ease;
        z-index: 2;
        /* Añade una transición al movimiento */
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .sidebar li {
        padding: 15px 20px;
    }

    .sidebar li i {
        font-size: 20px;
        color: #fff;
    }

    /* Estilo para la lista */
    li {
        display: flex;

        position: relative;
        /* Asegura que el contenedor li tenga una posición relativa */

        /* Usa flexbox para alinear los elementos horizontalmente */
        align-items: center;
        /* Centra verticalmente los elementos */
    }

    /* Estilo para el icono */
    i {
        margin-right: 8px;
        /* Espacio a la derecha del icono */
    }


    .sidebar a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        display: block;
    }

    .sidebar a:hover {
        background-color: #555;
    }

    .container {
        display: none;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
        transition: margin-left 0.3s ease;
        margin-top: 40px;
        /* Añade una transición al movimiento del contenido */
    }

    .contenido {
        padding: 20px;
        transition: margin-left 0.3s ease;
        margin-bottom: -40px;
        /* Añade una transición al movimiento del contenido */
    }

    .nav-container .checkbox {
        position: absolute;
        display: block;
        height: 32px;
        width: 32px;
        top: 20px;
        left: 20px;
        z-index: 5;
        opacity: 0;
        cursor: pointer;
    }

    .nav-container .hamburger-lines {
        display: block;
        height: 26px;
        width: 32px;
        position: absolute;
        top: 17px;
        left: 20px;
        z-index: 3;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .nav-container .hamburger-lines .line {
        display: block;
        height: 4px;
        width: 100%;
        border-radius: 10px;
        background: #0e2431;
    }

    .nav-container .hamburger-lines .line1 {
        transform-origin: 0% 0%;
        transition: transform 0.4s ease-in-out;
    }

    .nav-container .hamburger-lines .line2 {
        transition: transform 0.2s ease-in-out;
    }

    .nav-container .hamburger-lines .line3 {
        transform-origin: 0% 100%;
        transition: transform 0.4s ease-in-out;
    }

    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line1 {
        transform: rotate(45deg);
    }

    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line2 {
        transform: scaleY(0);
    }

    .nav-container input[type="checkbox"]:checked~.hamburger-lines .line3 {
        transform: rotate(-45deg);
    }

    .estado-rojo::before {
        content: "\2022";
        /* Código Unicode del punto */
        color: red;
        /* Color rojo */
        font-weight: bold;
        font-size: 20px;
        margin-left: 12px;
        position: absolute;
        /* Posiciona el punto absolutamente dentro del contenedor padre */
        top: 0;
        /* Alinea con el borde superior del contenedor */
        left: 0;
        /* Alinea con el borde izquierdo del contenedor */
    }

    @media screen and (max-width: 768px) {
        .sidebar {
            left: -250px;
            /* Ajusta para que esté visible en dispositivos móviles */
        }

        .container {
            display: block;
        }

        .content {
            margin-left: 0px;
        }
    }
</style>

<div class="container nav-container">
    <input class="checkbox" type="checkbox" onclick="toggleSidebar()" name="" id="" />
    <div class="hamburger-lines">
        <span class="line line1"></span>
        <span class="line line2"></span>
        <span class="line line3"></span>
    </div>
</div>

<!-- Menú lateral -->
<div class="sidebar">
    <h4 class="text-center" style="color:white">Menu</h4>
    <ul>
        <li>
            <i class="fa-solid fa-calendar-days"></i> <a href="../ADMIN/">Calendario</a>
        </li>
        <?php
        // Consulta SQL para obtener el conteo de formularios con Estado_Visto 'Faltante'
        $sql1 = "SELECT COUNT(*) AS total FROM `formulario_contacto` WHERE Estado_Visto='Faltante';";

        // Ejecutar la consulta
        $resultado = $conexion->query($sql1);
        $faltante = $resultado->fetch_assoc()['total'] > 0;

        // Mostrar el resultado correspondiente según el estado de los formularios
        ?>
        <li>
            <?php if ($faltante) : ?>
                <span class='estado-rojo'>&bull;</span>
            <?php endif; ?>
            <i class='fa-solid fa-table-list'></i>
            <a href='../ADMIN/forms.php'>Ultimos Formularios</a>
        </li>


        <li><a href="#">Servicios</a></li>
        <li><a href="#">Contacto</a></li>
        <li>
            <i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i><a href="logout.php">Cerrar sesión</a>
        </li>
    </ul>
</div>


<script>
    function toggleSidebar() {
        var sidebar = document.querySelector(".sidebar");
        var content = document.querySelector(".content");
        if (sidebar.style.left === "0px") {
            sidebar.style.left = "-250px";
            content.style.marginLeft = "0px"; /* Oculta el menú si está visible */
        } else {
            sidebar.style.left = "0";
            content.style.marginLeft =
                "250px"; /* Muestra el menú si está oculto */
        }
    }
</script>