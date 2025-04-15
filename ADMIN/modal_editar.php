<div class="modal fade" id="exampleModal<?php echo $row["ID"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Paciente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="crear_paciente.php" style="display:none">
                    <input type="hidden" name="id" value="<?php echo $row["ID"] ?> ">
                    <div class="form-group ">
                        <label for="nombre_paciente" class="col-form-label cap">
                            Nombre del paciente:
                        </label>
                        <input type="text" name="nombre_paciente" value="<?php echo $row["Nombre"] ?> " class="form-control cap" required>
                    </div>
                    <div class="form-group">
                        <label for="rut_paciente" class="col-form-label cap">
                            Rut del paciente:
                        </label>
                        <input type="text" name="rut_paciente" value=" " class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="correo_paciente" class="col-form-label cap">
                            Correo del paciente:
                        </label>
                        <input type="email" name="correo_paciente" value="<?php echo $row["Correo"] ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fono_paciente" class="col-form-label cap">
                            Telefono del paciente:
                        </label><br>
                        <span id="error-fono" class="error-message"></span>
                        <input type="text" name="fono_paciente" id="fono_paciente" value="<?php echo $row["Fono"] ?>" class="input form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_paciente" class="col-form-label cap">
                            Fecha de Nacimiento del paciente:
                        </label><br>
                        <input type="date" name="fecha_paciente" value="" class="form-control" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="notas_paciente" class="col-form-label cap">Notas adicionales:</label>
                        <textarea id="notas_paciente" name="notas_paciente" rows="4" cols="50" class="form-control"></textarea><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="crear_paciente" class="btn btn-primary">Registrar Paciente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>