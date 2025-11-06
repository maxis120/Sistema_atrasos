<?php
include("conexion.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Eliminar Atraso</title>
</head>
<body>
<?php
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$eliminar = "DELETE FROM atrasos WHERE id_atraso='$id'";
	$ejecutar = mysqli_query($con, $eliminar);
	
	if ($ejecutar) {
		header("Location: sistemaAtrasos.php?mensaje=Atraso eliminado exitosamente&tipo=success");
		exit;
	} else {
		header("Location: sistemaAtrasos.php?mensaje=Error al eliminar el atraso&tipo=error");
		exit;
	}
} else {
	header("Location: sistemaAtrasos.php");
	exit;
}
?>
</body>
</html>

