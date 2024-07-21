<?php
include("../../bd.php");
if ($_POST) {
    print_r($_POST);

    //Recolectamos los datos del metodo POST
    $nombrepuesto = (isset($_POST["nombrepuesto"])?$_POST["nombrepuesto"]:"");
    // Preparar la insercion
    $sentencia=$conexion->prepare("INSERT INTO puestos(id,nombrepuesto) 
               VALUES (null, :nombrepuesto)");
    // Vinculamos los parametros a las variables
    $sentencia->bindParam(":nombrepuesto", $nombrepuesto);
    // Ejecutamos la sentencia
    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location:index.php?mensaje=".$mensaje);
}
?>


<?php include("../../plantillas/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombrepuesto" class="form-label">Nombre del puesto</label>
                <input type="text" class="form-control" name="nombrepuesto" id="nombrepuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../plantillas/footer.php"); ?>



