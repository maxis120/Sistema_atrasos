<?php
session_start();
include("conexion.php");
error_reporting(0);

// Verificar que esté logueado
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: login.php");
    exit;
}

// Construir la consulta según el tipo de usuario
if ($_SESSION['tipo_usuario'] == 'padre') {
    // Si es padre, solo ver los atrasos de estudiantes (no empleados)
    // y que coincidan parcialmente con su RUT (simulando relación)
    $cedula_padre = $_SESSION['cedula'];
    
    // Si se busca una cédula específica, verificar que sea estudiante
    if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
        $cedula_buscar = mysqli_real_escape_string($con, $_GET['cedula']);
        $listar = "SELECT * FROM atrasos WHERE cedula = '$cedula_buscar' AND tipo = 'estudiante' ORDER BY fecha DESC, hora DESC";
    } else {
        // Mostrar solo atrasos de estudiantes (no todos los estudiantes tienen que estar relacionados)
        $listar = "SELECT * FROM atrasos WHERE tipo = 'estudiante' ORDER BY fecha DESC, hora DESC";
    }
} else {
    // Si es funcionario, ver todo o filtrar por búsqueda
    if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
        $cedula_buscar = mysqli_real_escape_string($con, $_GET['cedula']);
        $listar = "SELECT * FROM atrasos WHERE cedula = '$cedula_buscar' ORDER BY fecha DESC, hora DESC";
    } else {
        $listar = "SELECT * FROM atrasos ORDER BY fecha DESC, hora DESC";
    }
}

$ejecutalistar = mysqli_query($con, $listar);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LISTADO DE ATRASOS</title>
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
		.sin-resultados {
			text-align: center;
			color: #666;
			font-style: italic;
			padding: 40px;
		}
	</style>
</head>
<body>
	<div class="container">
		<a href="index.php" class="volver-btn">← Volver al Menú</a>
		
		<?php if ($_SESSION['tipo_usuario'] == 'padre' && isset($_GET['cedula'])) { 
			// Obtener nombre del estudiante
			$cedula_buscar = mysqli_real_escape_string($con, $_GET['cedula']);
			$nombre_query = "SELECT nombre FROM atrasos WHERE cedula = '$cedula_buscar' AND tipo = 'estudiante' LIMIT 1";
			$nombre_result = mysqli_query($con, $nombre_query);
			$nombre_estudiante = "Estudiante";
			if ($row = mysqli_fetch_assoc($nombre_result)) {
				$nombre_estudiante = $row['nombre'];
			}
		?>
			<h3>📋 ATRASOS DE: <?php echo $nombre_estudiante; ?> (Cédula: <?php echo $cedula_buscar; ?>)</h3>
		<?php } elseif ($_SESSION['tipo_usuario'] == 'padre') { ?>
			<h3>📋 ATRASOS DE ESTUDIANTES</h3>
		<?php } else { ?>
			<h3>📋 LISTADO DE ATRASOS</h3>
		<?php } ?>
		
		<table>
			<thead>
				<tr>
					<th>TIPO</th>
					<th>CÉDULA</th>
					<th>NOMBRE</th>
					<th>FECHA</th>
					<th>HORA</th>
					<th>MOTIVO</th>
				</tr>
			</thead>
			<tbody>
<?php
$tiene_resultados = false;
while ($rs=mysqli_fetch_array($ejecutalistar)) {
$tiene_resultados = true;
$tipo=$rs["tipo"];
$cedula=$rs["cedula"];
$nombre=$rs["nombre"];
$fecha=$rs["fecha"];
$hora=$rs["hora"];
$motivo=$rs["motivo"];
$fecha_formateada = date('d/m/Y', strtotime($fecha));
?>
<tr>
	<td><?php echo ucfirst($tipo);?></td>
	<td><?php echo $cedula;?></td>
	<td><?php echo $nombre;?></td>
	<td><?php echo $fecha_formateada;?></td>
	<td><?php echo $hora;?></td>
	<td><?php echo $motivo ? $motivo : '-';?></td>
</tr>
<?php
}

if (!$tiene_resultados) {
?>
<tr>
	<td colspan="6" class="sin-resultados">No se encontraron atrasos registrados.</td>
</tr>
<?php
}
?>	
			</tbody>
		</table>
	</div>
</body>
</html>