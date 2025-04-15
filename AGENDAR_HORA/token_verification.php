<?php
include '../bd.php';

function generateRandomKey($minLength = 5, $maxLength = 15) {
    $length = rand($minLength, $maxLength);
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function decrypt($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function verifyToken($conexion, $token) {
    $secret_key = generateRandomKey();

    $stmt = $conexion->prepare("SELECT * FROM Tokens WHERE Token = ? AND Fecha_Expiracion > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $token_data = $result->fetch_assoc();

    if ($token_data) {
        // Desencriptar el token usando la clave secreta actual
        $decrypted_token = decrypt($token_data['Token'], $token_data['Clave']);

        if ($decrypted_token) {
            list($id_formulario, $fecha_expiracion) = explode('|', $decrypted_token);

            // Actualizar el último acceso
            $stmt = $conexion->prepare("UPDATE Tokens SET Ultimo_Acceso = NOW() WHERE ID = ?");
            $stmt->bind_param("i", $token_data['ID']);
            $stmt->execute();

            return true;
        } else {
            echo "Error al desencriptar el token.";
            return false;
        }
    } else {
        echo "Lo siento, este enlace no es válido o ha expirado.";
        return false;
    }
}
?>