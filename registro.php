<?php
include("conexion.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>REGISTRAR</title>
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
		<h3>📝 FORMULARIO DE REGISTRO</h3>
		<form name="form1" method="post" action="registro.php">
			<div class="form-group">
				<label>TIPO:</label>	
				<select name="txt_tipo" required>
					<option value="">Seleccione...</option>
					<option value="empleado">Empleado</option>
					<option value="estudiante">Estudiante</option>
				</select>
			</div>
			<div class="form-group">
				<label>CÉDULA:</label>	
				<input type="text" name="txt_cedula" required>
			</div>
			<div class="form-group">
				<label>NOMBRE:</label>	
				<input type="text" name="txt_nombre" required>
			</div>
			<div class="form-group">
				<label>FECHA:</label>	
				<input type="date" name="txt_fecha" required>
			</div>
			<div class="form-group">
				<label>HORA:</label>	
				<input type="time" name="txt_hora" required>
			</div>
			<div class="form-group">
				<label>MOTIVO:</label>	
				<input type="text" name="txt_motivo">
			</div>
			<center>
				<input type="submit" name="btn_guardar" value="REGISTRAR">
			</center>
		</form>
	</div>
	
<?php
if ($_POST['btn_guardar']) {
	$tipo=$_POST['txt_tipo'];
	$cedula=$_POST['txt_cedula'];
	$nombre=$_POST['txt_nombre'];
	$fecha=$_POST['txt_fecha'];
	$hora=$_POST['txt_hora'];
	$motivo=$_POST['txt_motivo'];

	$insertar="INSERT INTO atrasos (tipo, cedula, nombre, fecha, hora, motivo) VALUES ('$tipo','$cedula','$nombre','$fecha','$hora','$motivo')";
	$ejecutar=mysqli_query($con,$insertar);
	if ($ejecutar) {
?>
<script language="javascript">
	alert('REGISTRO CORRECTO');
	window.location.href='index.php';
</script>
<?php
	} else {
?>
<script language="javascript">
	alert('ERROR AL REGISTRAR');
</script>
<?php
	}
}
?>
</body>
</html>
