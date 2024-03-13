<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: rgb(195, 34, 34);
            background: linear-gradient(108deg, rgba(195, 34, 34, 1) 21%, rgba(229, 165, 28, 1) 91%);
            /* Colores inspirados en la bandera alemana */
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;

            height: 100vh;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
            /* Ajusta el tamaño del icono según sea necesario */
            height: 150px;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.8);
            /* Fondo semitransparente */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            height: max-content;
            /* Sombra suave */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            /* Color de fondo del botón */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
            /* Cambia el color de fondo del botón al pasar el ratón */
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <a href="../">
                <!-- Icono de página web (cambia la ruta según la ubicación de tu icono) -->
                <img src="./imagenes/zyro-image (1)-fotor-20240229173153.png" alt="Icono de página web">
            </a>
        </div>
        <div class="login-form">
            <!-- Formulario de inicio de sesión aquí -->
            <form action="inicio.php" method="POST">
                <h2 style="text-align: center;">Iniciar sesión</h2>
                <div class="form-group">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>

</html>