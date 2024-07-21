<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT *, (SELECT nombrepuesto 
    FROM puestos 
    WHERE puestos.id=empleados.idpuesto limit 1) as  puesto FROM `empleados` WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    //print_r($registro);

    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];

    $nombrecompleto = $primernombre . " " . $segundonombre . " " . $primerapellido . "  " . $segundoapellido;

    $foto = $registro['foto'];
    $cv = $registro['cv'];
    $idpuesto = $registro['idpuesto'];
    $puesto = $registro['puesto'];
    $fechaingreso = $registro['fechaingreso'];

    $fechainicio = new DateTime($fechaingreso);
    $fechafin = new DateTime(date('Y-m-d'));
    $diferencia = date_diff($fechainicio, $fechafin);
}
ob_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendacion</title>
</head>

<body>

    <h1>Carta de recomendacion laboral</h1>
    <br>
    Bogota, Colombia a <strong> <?php echo date('d M Y');?></strong>
    <br>
    Reciba un coordial y respetuoso saludo
    <br>
    por mediio de esta carta hago constar que el señor(a) <strong> <?php echo $nombrecompleto; ?></strong>;
    quien laboro en esta empresa durante <strong> <?php echo $diferencia->y; ?> año(s) </strong>, es un ciudadano con conducta intachable.
    <br>
    Ha demostrado ser un excelente trabajador, comprometido, responsable y file cumplidor de sus tareas.
    <br>
    A lo largo del tiempo ha desempeñado diferentes funciones dentro de la organización,
    permitiéndole desarrollar habilidades y conocimientos en diversas áreas como:
    <br>
    back-end
    <br>
    frond-end
    <br>
    Durante estos años ha desempeñado el cargo de <strong><?php echo $puesto;?></strong>
    <br><br><br><br><br>

_____________________ <br>
    coordialmente
    <br><br><br>
    Angela Romero
    <br>
    Analista Talento Humano
</body>

</html>

<?php
$HTML=ob_get_clean();
require_once("../../librerias/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf= new Dompdf();
$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEneabled"=>true));

$dompdf->setOptions($opciones);

$dompdf->loadHtml($HTML);

$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf",array("Attachment"=>false));


?>