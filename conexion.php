<?php
$servidor="127.0.0.1";
$usuario="root";
$clave="";
$bd="SistemaAtrasos";
$con= mysqli_connect($servidor,$usuario,$clave,$bd);

if (!$con) {
	die("ERROR DE CONEXION: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");

?>