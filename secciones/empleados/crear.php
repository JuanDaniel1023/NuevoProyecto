<?php
include("../../bd.php");

if ($_POST) {
    //print_r($_POST);
    //print_r($_FILES);

    $primernombre = (isset($_POST['primernombre'])) ? $_POST['primernombre'] : "";
    $segundonombre = (isset($_POST['segundonombre'])) ? $_POST['segundonombre'] : "";
    $primerapellido = (isset($_POST["primerapellido"])) ? $_POST["primerapellido"] : "";
    $segundoapellido = (isset($_POST['segundoapellido'])) ? $_POST['segundoapellido'] : "";

    $foto = (isset($_FILES['foto']['name'])) ? $_FILES['foto']['name'] : "";
    $cv = (isset($_FILES['cv']['name'])) ? $_FILES['cv']['name'] : "";

    $idpuesto = (isset($_POST['idpuesto'])) ? $_POST['idpuesto'] : "";
    $fechaingreso = (isset($_POST['fechaingreso'])) ? $_POST['fechaingreso'] : "";

    if (!empty($fechaingreso)) {
        $fechaingreso = date("Y-m-d", strtotime($fechaingreso));
    } else {
        // Si la fecha está vacía, puedes asignar un valor predeterminado o manejarlo de otra manera.
        // Por ejemplo, podrías asignar la fecha actual.
        $fechaingreso = date("Y-m-d");
    }

    $sentencia = $conexion->prepare("INSERT INTO `empleados` (`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuesto`, `fechaingreso`) 
    VALUES (NULL, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :cv, :idpuesto, :fechaingreso)");

    $sentencia->bindParam(":primernombre", $primernombre);
    $sentencia->bindParam(":segundonombre", $segundonombre);
    $sentencia->bindParam(":primerapellido", $primerapellido);
    $sentencia->bindParam(":segundoapellido", $segundoapellido);

    $fecha = new DateTime();

    $nombreArchivo_foto = ($foto != "") ? $fecha->getTimestamp() . "_" . $_FILES['foto']['name'] : "";
    $tmp_foto = $_FILES['foto']['tmp_name'];
    if ($tmp_foto != "") {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
    }
    $sentencia->bindParam(":foto", $nombreArchivo_foto);

    $nombreArchivo_cv = ($cv != "") ? $fecha->getTimestamp() . "_" . $_FILES['cv']['name'] : "";
    $tmp_cv = $_FILES['cv']['tmp_name'];
    if ($tmp_cv != "") {
        move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
    }
    $sentencia->bindParam(":cv", $nombreArchivo_cv);






   //$sentencia->bindParam(":cv", $cv);

    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechaingreso", $fechaingreso);
    $sentencia->execute();

    $mensaje="Registro Agregado";
    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM puestos");
$sentencia->execute();
$lista_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include("../../plantillas/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        Agregar datos
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer Nombre">
            </div>

            <div class="mb-3">
                <label for="segundonombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo Nombre">
            </div>

            <div class="mb-3">
                <label for="primerapellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer Apellido">
            </div>

            <div class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apellido">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">CV(PDF)</label>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_puestos as $registro) { ?>
                        <option value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['nombrepuesto']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Fecha de ingreso</label>
                <input type="date" class="form-control" name="fechaingreso" id="fechaingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
            </div>

            <button type="submit" class="btn btn-success">Agregar registro</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include("../../plantillas/footer.php"); ?>