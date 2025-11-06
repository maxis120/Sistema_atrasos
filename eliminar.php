<?php
include("conexion.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Eliminar</title>
	<link rel="stylesheet" href="estilos.css">
	<style>
		.volver-btn {
			display: inline-block;
			background: #667eea;
			color: white;
			padding: 10px 20px;
			text-decoration: none;
			border-radius: 8px;
			margin-bottom: 20px;
			font-weight: 600;
			transition: all 0.3s ease;
		}
		.volver-btn:hover {
			background: #5a67d8;
			transform: translateY(-2px);
		}
	</style>
</head>
<body>
	<div class="container">
		<a href="index.php" class="volver-btn">← Volver al Menú</a>
		<h3>🗑️ FORMULARIO ELIMINAR</h3>
		<form name="form1" method="post" action="eliminar.php">
			<div class="form-group">
				<label>ATRASOS:</label>
				<select name="cbo_usu" required>
					<option value="0">Seleccione...</option>
					<?php
					$listar="SELECT * FROM atrasos";
					$ejecutalistar=mysqli_query($con,$listar);
					while ($rs=mysqli_fetch_array($ejecutalistar)) {
						echo "<option value='".$rs['id_atraso']."'>".$rs['nombre']." - ".$rs['cedula']." - ".$rs['fecha']."</option>";
					}
					?>
				</select>
			</div>
			<center>
				<input type="submit" name="btn_eliminar" value="ELIMINAR">	
			</center>
		</form>
	</div>
	
<?php
if ($_POST['btn_eliminar']) {
	$id=$_POST['cbo_usu'];
	if ($id != '0') {
		$eliminar="DELETE FROM atrasos WHERE id_atraso='$id'";
		$ejecutar=mysqli_query($con,$eliminar);
		if ($ejecutar) {
?>
<script language="javascript">
	alert('ELIMINACIÓN CORRECTA');
	window.location.href='index.php';
</script>
<?php
		} else {
?>
<script language="javascript">
	alert('ERROR AL ELIMINAR');
</script>
<?php
		}
	} else {
?>
<script language="javascript">
	alert('SELECCIONE UN ATRASO');
</script>
<?php
	}
}
?>
</body>
</html>
