<div class="modal fade" id="ModalDelete<?php echo $row["ID"] ?>" tabindex="-1" aria-labelledby="ModalDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="ModalDelete"> ¿Realmente deseas eliminar la consulta?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="crear_paciente.php">
                    <input type="hidden" name="id" value="<?php echo $row["ID"] ?> ">
                    <h1 class="modal-title text-center">
                        <?php echo $row['Nombre']; ?>
                    </h1>
                    <h4 class="modal-title text-center">
                        <?php echo $row['Fecha_Formulario']; ?>
                    </h4>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="eliminar_consulta" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>