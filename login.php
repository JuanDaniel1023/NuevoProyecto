<?php
session_start();
include("./bd.php");

if ($_POST) {
    // Prepara la consulta SQL
    $sentencia = $conexion->prepare("SELECT usuarios.id, usuarios.usuario, usuarios.password, usuarios.correo, usuarios.idrol, roles.nombre
    FROM `usuarios`
    LEFT JOIN roles ON usuarios.idrol = roles.idrol
    WHERE usuario = :usuario AND password = :password;
    ");

    // Obtén los valores de usuario y contraseña del formulario POST
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Vincula los parámetros a la consulta
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);

    // Ejecuta la consulta
    $sentencia->execute();

    // Obtiene el resultado de la consulta
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verifica si se encontró un usuario válido
   if ($registro !== false) {
        // Iniciar sesión correcta
        $_SESSION["usuario"] = $registro["usuario"];
        $_SESSION["login"] = true;

        // Asigna el rol del usuario a la variable de sesión
        $_SESSION['rol'] = $registro['nombre']; // Nombre del rol en lugar de idrol

        // Redirecciona al usuario según su rol
        if ($_SESSION['rol'] == "Administrador") {
            header("Location: index.php"); // Redirige a la página de administrador
        } else {
            header("Location: usuario.php"); // Redirige a la página de usuario regular
        }
    } else {
        // Error: el usuario o la contraseña son incorrectos
        $mensaje = "Error, el usuario o la contraseña son incorrectos";
    }
}

?>


<!doctype html>
<html lang="es ">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="container">

        <div class="row">
            <div class="col-md-4">

            </div>

            <div class="col-md-4">
                <br><br>
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <?php if (isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo $mensaje; ?></strong>
                            </div>
                        <?php } ?>
                        <form action="" method="post">

                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Escriba su usuario" />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Escriba su contraseña" />
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Ingresar
                            </button>


                        </form>

                    </div>

                </div>

            </div>


        </div>



    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>