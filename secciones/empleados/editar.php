<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `empleados` WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];


    $foto = $registro['foto'];
    $cv = $registro['cv'];


    $idpuesto = $registro['idpuesto'];
    $fechaingreso = $registro['fechaingreso'];

    $sentencia = $conexion->prepare("SELECT * FROM puestos");
    $sentencia->execute();
    $lista_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

if ($_POST) {
    //print_r($_POST);
    //print_r($_FILES);
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $primernombre = (isset($_POST['primernombre'])) ? $_POST['primernombre'] : "";
    $segundonombre = (isset($_POST['segundonombre'])) ? $_POST['segundonombre'] : "";
    $primerapellido = (isset($_POST["primerapellido"])) ? $_POST["primerapellido"] : "";
    $segundoapellido = (isset($_POST['segundoapellido'])) ? $_POST['segundoapellido'] : "";
    $idpuesto = (isset($_POST['idpuesto'])) ? $_POST['idpuesto'] : "";
    $fechaingreso = (isset($_POST['fechaingreso'])) ? $_POST['fechaingreso'] : "";

    if (!empty($fechaingreso)) {
        $fechaingreso = date("Y-m-d", strtotime($fechaingreso));
    } else {
        $fechaingreso = date("Y-m-d");
    }

    $sentencia = $conexion->prepare("
    UPDATE `empleados` SET 
    primernombre=:primernombre,
    segundonombre=:segundonombre,
    primerapellido=:primerapellido,
    segundoapellido=:segundoapellido,
    idpuesto=:idpuesto,
    fechaingreso=:fechaingreso
    WHERE id=:id");

    $sentencia->bindParam(":primernombre", $primernombre);
    $sentencia->bindParam(":segundonombre", $segundonombre);
    $sentencia->bindParam(":primerapellido", $primerapellido);
    $sentencia->bindParam(":segundoapellido", $segundoapellido);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechaingreso", $fechaingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();


    $fecha = new DateTime();


    $foto = (isset($_FILES['foto']['name'])) ? $_FILES['foto']['name'] : "";
    $nombreArchivo_foto = ($foto != "") ? $fecha->getTimestamp() . "_" . $_FILES['foto']['name'] : "";
    $tmp_foto = $_FILES['foto']['tmp_name'];

    if ($tmp_foto != "") {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
        $sentencia = $conexion->prepare("SELECT foto FROM `empleados` WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_recuperado['foto']) && $registro_recuperado['foto'] != "") {
            if (file_exists("./" . $registro_recuperado['foto'])) {
                unlink("./" . $registro_recuperado['foto']);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `empleados` SET foto=:foto WHERE id=:id");
        $sentencia->bindParam(":foto", $nombreArchivo_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    $cv = (isset($_FILES['cv']['name'])) ? $_FILES['cv']['name'] : "";
    $nombreArchivo_cv = ($cv != "") ? $fecha->getTimestamp() . "_" . $_FILES['cv']['name'] : "";
    $tmp_cv = $_FILES['cv']['tmp_name'];

    if ($tmp_cv != "") {
        move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
        $sentencia = $conexion->prepare("SELECT cv FROM `empleados` WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_recuperado['cv']) && $registro_recuperado['cv'] != "") {
            if (file_exists("./" . $registro_recuperado['cv'])) {
                unlink("./" . $registro_recuperado['cv']);
            }
        }
        
        $sentencia = $conexion->prepare("UPDATE `empleados` SET cv=:cv WHERE id=:id");
        $sentencia->bindParam(":cv", $nombreArchivo_cv);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }


    $mensaje="Registro Actualizado";
    header("Location:index.php?mensaje=".$mensaje);
}

?>



<?php include("../../plantillas/header.php"); ?>

Editar Empleados

<br>

<div class="card">
    <div class="card-header">
        Agregar datos
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer Nombre</label>
                <input type="text" value="<?php echo $primernombre; ?>" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer Nombre">
            </div>

            <div class="mb-3">
                <label for="segundonombre" class="form-label">Segundo Nombre</label>
                <input type="text" value="<?php echo $segundonombre; ?>" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo Nombre">
            </div>

            <div class="mb-3">
                <label for="primerapellido" class="form-label">Primer Apellido</label>
                <input type="text" value="<?php echo $primerapellido; ?>" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer Apellido">
            </div>

            <div class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo Apellido</label>
                <input type="text" value="<?php echo $segundoapellido; ?>" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apellido">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <br>
                <img width="80" src="<?php echo $foto; ?>" class=" rounded" alt="" />
                <br><br>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">CV(PDF)</label>
                <br>
                <a href="<?php echo $cv; ?>"><?php echo $cv; ?></a>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>

                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_puestos as $registro) { ?>


                        <option <?php echo ($idpuesto == $registro['id']) ? "selected" : ""; ?> value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['nombrepuesto']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Fecha de ingreso</label>
                <input type="date" value="<?php echo $fechaingreso; ?>" class="form-control" name="fechaingreso" id="fechaingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
            </div>

            <button type="submit" class="btn btn-success">Actualizar registro</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include("../../plantillas/footer.php"); ?>