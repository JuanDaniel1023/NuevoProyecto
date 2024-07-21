<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    // Verificar si hay empleados asociados a este puesto
    $sentencia = $conexion->prepare("SELECT COUNT(*) FROM empleados WHERE idpuesto=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje="Registro Eliminado";
    $nmensaje="No se puede eliminar registro";
    $num_empleados_asociados = $sentencia->fetchColumn();

    if ($num_empleados_asociados > 0) {
        // Mostrar advertencia de que no se puede eliminar
         header("Location:index.php?mensaje=".$nmensaje);
    } else {
        // No hay empleados asociados, se puede eliminar
        $sentencia = $conexion->prepare("DELETE FROM puestos WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        header("Location:index.php?mensaje=".$mensaje);
    }
}


//if (isset($_GET['txtID'])) {

   // $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
  //  $sentencia = $conexion->prepare("DELETE FROM puestos WHERE id=:id");
  //  $sentencia->bindParam(":id", $txtID);
   // $sentencia->execute();
  //  $mensaje="Registro Eliminado";
  //  header("Location:index.php?mensaje=".$mensaje);
//}

$sentencia = $conexion->prepare("SELECT * FROM puestos");
$sentencia->execute();
$lista_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//print_r($lista_puestos);
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
                        <th scope="col">Nombre del Puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_puestos as $registro) { ?>

                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombrepuesto']; ?></td>
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


<script>
    function borrar(id) {

        Swal.fire({
            title: "Desea boorar el registro?",
            //showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Si",
            // denyButtonText: `Don't save`
        }).then((result) => {

            if (result.isConfirmed) {
                window.location = "index.php?txtID=" + id;
            }
            
        })
    }
</script>

<?php include("../../plantillas/footer.php"); ?>