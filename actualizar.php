<?php
include("conexion.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ACTUALIZAR</title>
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
		<h3>✏️ ACTUALIZAR ATRASO</h3>
		<form name="form1" method="post" action="actualizar.php">
			<div class="form-group">
				<label>ATRASOS:</label>
				<select name="cbo_usu" required>
					<option value="0">Seleccione...</option>
					<?php
					$listar="SELECT * FROM atrasos";
					$ejecutalistar=mysqli_query($con,$listar);
					while ($rs=mysqli_fetch_array($ejecutalistar)) {
						$selected = (isset($_POST['cbo_usu']) && $_POST['cbo_usu'] == $rs['id_atraso']) ? 'selected' : '';
						echo "<option value='".$rs['id_atraso']."' $selected>".$rs['nombre']." - ".$rs['cedula']." - ".$rs['fecha']."</option>";
					}
					?>
				</select>
			</div>
			<center>
				<input type="submit" name="btn_buscar" value="BUSCAR">
			</center>
		</form>
		
		<?php
		$id="";
		$tipo="";
		$cedula="";
		$nombre="";
		$fecha="";
		$hora="";
		$motivo="";

		// Si viene desde sistemaAtrasos.php con parámetro buscar
		if (isset($_GET['buscar'])) {
			$buscar=$_GET['buscar'];
			$listar="SELECT * FROM atrasos WHERE id_atraso='$buscar'";
			$ejecutalistar=mysqli_query($con,$listar);
			while ($rs=mysqli_fetch_array($ejecutalistar)) {
				$id=$rs["id_atraso"];
				$tipo=$rs["tipo"];
				$cedula=$rs["cedula"];
				$nombre=$rs["nombre"];
				$fecha=$rs["fecha"];
				$hora=$rs["hora"];
				$motivo=$rs["motivo"];
			}
		} elseif ($_POST['btn_buscar']) {
			$buscar=$_POST['cbo_usu'];
			if ($buscar != '0') {
				$listar="SELECT * FROM atrasos WHERE id_atraso='$buscar'";
				$ejecutalistar=mysqli_query($con,$listar);
				while ($rs=mysqli_fetch_array($ejecutalistar)) {
					$id=$rs["id_atraso"];
					$tipo=$rs["tipo"];
					$cedula=$rs["cedula"];
					$nombre=$rs["nombre"];
					$fecha=$rs["fecha"];
					$hora=$rs["hora"];
					$motivo=$rs["motivo"];
				}
			}
		}
		?>
		
		<?php if ($id != "") { ?>
		<form name="form2" method="post" action="actualizar.php<?php if (isset($_GET['buscar'])) echo '?buscar='.$_GET['buscar']; ?>">
			<?php if (isset($_GET['buscar'])) { ?>
			<input type="hidden" name="desde_sistema" value="1">
			<?php } ?>
			<div class="form-group">
				<label>ID:</label>	
				<input type="text" name="txt_id" value="<?php echo $id; ?>" readonly>
			</div>
			<div class="form-group">
				<label>TIPO:</label>	
				<select name="txt_tipo" required>
					<option value="">Seleccione...</option>
					<option value="empleado" <?php if($tipo=='empleado') echo 'selected'; ?>>Empleado</option>
					<option value="estudiante" <?php if($tipo=='estudiante') echo 'selected'; ?>>Estudiante</option>
				</select>
			</div>
			<div class="form-group">
				<label>CÉDULA:</label>	
				<input type="text" name="txt_cedula" value="<?php echo $cedula; ?>" required>
			</div>
			<div class="form-group">
				<label>NOMBRE:</label>	
				<input type="text" name="txt_nombre" value="<?php echo $nombre; ?>" required>
			</div>
			<div class="form-group">
				<label>FECHA:</label>	
				<input type="date" name="txt_fecha" value="<?php echo $fecha; ?>" required>
			</div>
			<div class="form-group">
				<label>HORA:</label>	
				<input type="time" name="txt_hora" value="<?php echo $hora; ?>" required>
			</div>
			<div class="form-group">
				<label>MOTIVO:</label>	
				<input type="text" name="txt_motivo" value="<?php echo $motivo; ?>">
			</div>
			<center>
				<input type="submit" name="btn_actualizar" value="ACTUALIZAR">
			</center>
		</form>
		<?php } ?>
		
		<?php
		if ($_POST['btn_actualizar']) {
			$id=$_POST['txt_id'];
			$tipo=$_POST['txt_tipo'];
			$cedula=$_POST['txt_cedula'];
			$nombre=$_POST['txt_nombre'];
			$fecha=$_POST['txt_fecha'];
			$hora=$_POST['txt_hora'];
			$motivo=$_POST['txt_motivo'];
			
			$actualizar="UPDATE atrasos SET tipo='$tipo',cedula='$cedula',nombre='$nombre',fecha='$fecha',hora='$hora',motivo='$motivo' WHERE id_atraso='$id'";
			$ejecutar=mysqli_query($con,$actualizar);
			if ($ejecutar) {
				// Si viene de sistemaAtrasos, regresar ahí
				if (isset($_GET['buscar']) || isset($_POST['desde_sistema'])) {
		?>
		<script language="javascript">
			alert('ACTUALIZACIÓN CORRECTA');
			window.location.href='index.php?mensaje=Atraso actualizado exitosamente&tipo=success';
		</script>
		<?php
				} else {
		?>
		<script language="javascript">
			alert('ACTUALIZACIÓN CORRECTA');
			window.location.href='index.php';
		</script>
		<?php
				}
			} else {
		?>
		<script language="javascript">
			alert('ERROR AL ACTUALIZAR');
		</script>
		<?php
			}
		}
		?>
	</div>
</body>
</html>
