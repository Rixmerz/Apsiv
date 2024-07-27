<?php

if (!function_exists('encrypt')) {
    function encrypt($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
}

if (!function_exists('generateToken')) {
    function generateToken($id_formulario)
    {
        include '../bd.php';

        // Verificar si ya existe un token válido para este formulario
        $stmt = $conexion->prepare("SELECT Token, Fecha_Expiracion FROM Tokens WHERE ID_Formulario = ? AND Fecha_Expiracion > NOW()");
        $stmt->bind_param("i", $id_formulario);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingToken = $result->fetch_assoc();

        if ($existingToken) {
            return $existingToken['Token']; // Retorna el token existente
        }
    }
}


$id_formulario = $row["ID"]; // ID del formulario

// Intentar obtener un token existente
$encrypted_token = generateToken($id_formulario);

//echo "ID_Formulario:" . $id_formulario . "<br>Token:" . $encrypted_token . "<br>";
?>

<div class="modal fade" id="ModalToken<?php echo $row["ID"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Token de Toma de Horas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <?php if ($encrypted_token) : ?>
                        <p>Tu enlace de acceso es: <a href="../AGENDAR_HORA/index.php?token=<?php echo urlencode($encrypted_token); ?>"><?php echo "Token de acceso" ?></a></p>
                    <?php else : ?>
                        <figure class="text-center">
                            <a target="_blank" href="generate_link.php?variable=<?php echo urlencode($row["ID"]); ?>">
                                <button type="button" class="btn btn-primary">Crear nuevo token</button>
                            </a>
                        </figure>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>