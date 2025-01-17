<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");
    $sentencia->bindParam("id", $txtID);
    $sentencia->execute();

    $mensaje = "Registro Eliminado";
    header("Location:index.php?mensaje=" . $mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `usuarios`");
$sentencia->execute();
$lista_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>







<?php include("../../plantillas/header.php"); ?>



<br>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button"> Agregar Registro</a>
        
    </div>
    <div class="card-body">

        <div class="table-responsive-sm">
            <table class="table table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_usuarios as $registro) { ?>

                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['usuario']; ?></td>
                            <td>*******</td>
                            <td><?php echo $registro['correo']; ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>

                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>



<?php include("../../plantillas/footer.php"); ?>