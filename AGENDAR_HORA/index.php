<?php
include '../bd.php';
include 'token_verification.php';

if (isset($_GET['token'])) {
  $token = $_GET['token'];
  $isValid = verifyToken($conexion, $token);

  if ($isValid) {
    //echo "Acceso concedido. Bienvenido!";
?>


    <!DOCTYPE html>
    <html lang="es">

    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Agendar Hora</title>
      <style>
        body {
          margin: 0;
          padding: 0;
          font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
          background: rgb(195, 34, 34);
          background: linear-gradient(108deg,
              rgba(195, 34, 34, 1) 21%,
              rgba(229, 165, 28, 1) 91%);
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

        h2 {
          text-align: center;
          margin-bottom: 20px;
        }

        .input-container {
          margin-bottom: 15px;
        }

        label {
          display: block;
          margin-bottom: 5px;
        }

        select {
          width: 100% !important;
        }

        input[type="text"],
        input[type="password"],
        select {
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

        .error-message {
          color: red;
          margin-top: 5px;
        }
      </style>
    </head>

    <body>
      <div class="login-container">
        <div class="logo">
          <!-- Icono de página web (cambia la ruta según la ubicación de tu icono) -->
          <img src="../imagenes/zyro-image (1)-fotor-20240229173153.png" alt="Icono de página web" />
        </div>
        <div class="login-form">
          <form id="hora-form" action="dates.php" method="POST">
            <h2>Agenda tu Hora</h2>
            <div class="input-container">
              <label for="rut">Rut:</label>
              <input type="text" id="rut" name="rut" placeholder="Ej: 12.345.678-K" maxlength="12" required />
              <p id="rut-error" class="error-message"></p>
            </div>
            <div class="input-container">
              <label for="isapre">Isapre:</label>
              <select id="isapre" name="isapre" required>
                <option value="">Seleccione una opcion</option>
                <option value="FONASA">Fondo Nacional de Salud (FONASA)</option>
                <option value="Banmedica">Isapre Banmedica</option>
                <option value="Colmena Golden Cross">Isapre Colmena</option>
                <option value="Consalud">Isapre Consalud</option>
                <option value="Cruz Blanca">Isapre Cruz Blanca</option>
                <option value="Cruz del Norte">Isapre Cruz del Norte</option>
                <option value="Nueva MásVida">Isapre Nueva MásVida</option>
                <option value="Fundación">Isapre Fundación</option>
                <option value="Vida Tres">Isapre Vida Tres</option>
                <option value="Particular">Particular</option>
              </select>
            </div>
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <button type="submit">Buscar Hora</button>
          </form>
        </div>
      </div>

      <script>
        const rutInput = document.getElementById("rut");
        const rutError = document.getElementById("rut-error");
        const rutForm = document.getElementById("hora-form");

        rutForm.addEventListener("submit", function(event) {
          const rutValue = rutInput.value;
          const isValidRut = validateRut(rutValue);
          if (!isValidRut) {
            event.preventDefault(); // Evitar que el formulario se envíe
            rutError.textContent = "Rut inválido";
          } else {
            rutError.textContent = "";
          }
        });

        rutInput.addEventListener("input", function(event) {
          const rutValue = event.target.value;
          const isValidRut = validateRut(rutValue);
          if (!isValidRut) {
            rutError.textContent = "Rut inválido";
          } else {
            rutError.textContent = "";
          }
          const formattedRut = formatRut(rutValue);
          rutInput.value = formattedRut;
        });

        function formatRut(rut) {
          const cleanRut = rut.replace(/[^\w\s]/gi, "");
          const formattedRut = cleanRut.replace(
            /(\d{1,3})(\d{3})(\d{3})([\dKk])$/,
            "$1.$2.$3-$4"
          );
          return formattedRut;
        }

        function validateRut(rut) {
          const rutRegex = /^(\d{1,3})\.(\d{3})\.(\d{3})-(\d|K|k)$/;
          return rutRegex.test(rut);
        }
      </script>
    </body>

    </html>
<?php
  } else {
    echo "Acceso denegado.";
  }
} else {
  echo "Token no proporcionado.";
}

// Cerrar la conexión
$conexion->close();
?>