<?php
// Inicia la sesión
session_start();

// Destruye todas las variables de sesión
$_SESSION = array();

// Destruye la sesión
session_destroy();

// Invalida la cookie de sesión en el cliente
setcookie(session_name(), '', time()-42000, '/');

// Elimina todas las demás cookies si las hubiera
setcookie('cookie_name', '', time()-42000, '/');

header("Location: ../login.php");
exit;
