
<?php include("plantillas/header.php");

//session_start();

//if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "Administrador") {
    // El usuario no tiene permisos de administrador, redirige a una página de acceso denegado o muestra un mensaje de error.
 //   header("Location: acceso_denegado.php");
 //   exit();
//}

// Resto del contenido de la página para administradores



?>
<br>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Bienvenid@ al sistema</h1>
      <p class="col-md-8 fs-4">Usuario : <?php echo$_SESSION['usuario'];?></p>
      <button class="btn btn-primary btn-lg" type="button">Example button</button>
    </div>
  </div>

  <?php include("plantillas/footer.php");?>
 