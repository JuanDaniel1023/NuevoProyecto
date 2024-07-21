<?php
header("Access-Control-Allow-Origin: http://localhost");
$servidor= "localhost";
$baseDeDatos= "app";
$usuario="root";
$contrasena= "123456789";

try{
    $conexion= new PDO("mysql:host=$servidor; dbname=$baseDeDatos",$usuario,$contrasena);
}catch(Exception $ex){
    echo $ex ->getMessage();
}
?>