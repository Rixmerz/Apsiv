<?php

if (isset($_GET['variable'])) {
    $id_formulario = urldecode($_GET['variable']);
}

function encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}


function generateToken($id_formulario, $secret_key)
{
    include '../bd.php';


    // Verificar si ya existe un token válido para este formulario
    $stmt = $conexion->prepare("SELECT Fecha_Expiracion FROM Tokens WHERE ID_Formulario = ? AND Fecha_Expiracion > NOW()");
    $stmt->bind_param("i", $id_formulario);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingToken = $result->fetch_assoc();

    if ($existingToken) {
        return null; // Ya existe un token válido
    }

    $fecha_expiracion = date('Y-m-d H:i:s', strtotime('+7 days'));
    $token = $id_formulario . '|' . $fecha_expiracion;
    $encrypted_token = encrypt($token, $secret_key);

    // Guardar el token en la base de datos
    $stmt = $conexion->prepare("INSERT INTO Tokens (ID_Formulario, Token, Clave, Fecha_Expiracion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_formulario, $encrypted_token, $secret_key, $fecha_expiracion);
    $stmt->execute();

    return $encrypted_token;
}

function generateRandomKey($min = 5, $max = 15)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
    $length = rand($min, $max);
    $randomKey = '';

    for ($i = 0; $i < $length; $i++) {
        $randomKey .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomKey;
}


$secret_key = generateRandomKey();

echo "Clave secreta generada: " . $secret_key . "<br>";
echo "ID del Formulario:" . $id_formulario . "<br>";

$encrypted_token = generateToken($id_formulario, $secret_key);

if ($encrypted_token) {
    $link = "./index.php?token=" . urlencode($encrypted_token);
    header("Location: forms.php");
    exit;
}
