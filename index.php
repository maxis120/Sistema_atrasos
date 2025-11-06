<?php
session_start();
include("conexion.php");
error_reporting(0);

// Si no está logueado, redirigir al login
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: login.php");
    exit;
}

// Función para obtener los estudiantes (como no hay tabla de padres, mostramos todos los estudiantes)
function getEstudiantesPadre($conexion, $cedula_padre) {
    // Como no tenemos tabla de estudiantes ni relación padre-estudiante, 
    // vamos a obtener todos los estudiantes que tengan atrasos registrados
    $query = "SELECT DISTINCT cedula, nombre, 'Estudiante' as curso 
              FROM atrasos 
              WHERE tipo = 'estudiante' 
              ORDER BY nombre";
    $result = mysqli_query($conexion, $query);
    $estudiantes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $estudiantes[] = $row;
    }
    return $estudiantes;
}

// Si es padre, obtener sus estudiantes
$estudiantes = array();
if ($_SESSION['tipo_usuario'] == 'padre') {
    $estudiantes = getEstudiantesPadre($con, $_SESSION['cedula']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Control de Atrasos</title>
	<link rel="stylesheet" href="estilos.css">
	<style>
		.container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
		}
		.menu-principal {
			background: white;
			border-radius: 15px;
			padding: 30px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
		}
		.menu-opciones {
			display: grid;
			gap: 20px;
		}
		.menu-opciones a {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			min-height: 120px;
			padding: 30px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			text-decoration: none;
			border-radius: 15px;
			font-weight: 600;
			font-size: 18px;
			transition: all 0.3s ease;
			box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
		}
		.menu-opciones a:hover {
			transform: translateY(-8px);
			box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
		}
		.busqueda-padres {
			background: #f8f9fa;
			border-radius: 15px;
			padding: 30px;
			margin-top: 20px;
			text-align: center;
		}
		.busqueda-padres h2 {
			color: #667eea;
			margin-bottom: 20px;
		}
		.form-group {
			margin-bottom: 15px;
		}
		.form-control {
			width: 100%;
			max-width: 300px;
			padding: 12px;
			border: 2px solid #ddd;
			border-radius: 8px;
			font-size: 16px;
			margin: 0 auto;
			display: block;
		}
		.btn-buscar {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			border: none;
			padding: 12px 30px;
			border-radius: 8px;
			font-size: 16px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
		}
		.btn-buscar:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
		}
		.estudiantes-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 15px;
			margin-top: 20px;
		}
		.estudiante-card {
			background: white;
			border: 2px solid #667eea;
			border-radius: 10px;
			padding: 15px;
			text-align: center;
			cursor: pointer;
			transition: all 0.3s ease;
		}
		.estudiante-card:hover {
			background: #667eea;
			color: white;
			transform: translateY(-3px);
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="menu-principal">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
				<h1 style="margin: 0; color: #667eea;">📋 Sistema de Control de Atrasos</h1>
				<a href="logout.php" style="background: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: 600;">
					🚪 Cerrar Sesión
				</a>
			</div>
			<p style="text-align: center; color: #666; margin-bottom: 30px;">
				Usuario: <strong><?php echo $_SESSION['tipo_usuario'] == 'funcionario' ? 'Funcionario' : 'Padre/Apoderado'; ?></strong>
			</p>
			
			<?php if ($_SESSION['tipo_usuario'] == 'funcionario') { ?>
				<!-- Menú completo para funcionarios -->
				<div class="menu-opciones" style="grid-template-columns: repeat(2, 1fr); max-width: 800px; margin: 0 auto;">
					<a href="registro.php" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 120px; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 15px; font-weight: 600; font-size: 18px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
						<span style="font-size: 48px; margin-bottom: 10px;">📝</span>
						<span>REGISTRAR</span>
					</a>
					<a href="actualizar.php" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 120px; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 15px; font-weight: 600; font-size: 18px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
						<span style="font-size: 48px; margin-bottom: 10px;">✏️</span>
						<span>ACTUALIZAR</span>
					</a>
					<a href="eliminar.php" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 120px; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 15px; font-weight: 600; font-size: 18px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
						<span style="font-size: 48px; margin-bottom: 10px;">🗑️</span>
						<span>ELIMINAR</span>
					</a>
					<a href="listar.php" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 120px; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 15px; font-weight: 600; font-size: 18px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
						<span style="font-size: 48px; margin-bottom: 10px;">📋</span>
						<span>LISTAR</span>
					</a>
				</div>
			<?php } else { ?>
				<!-- Interfaz para padres - solo búsqueda de sus hijos -->
				<div class="busqueda-padres">
					<h2>🔍 Buscar Atrasos de sus Hijos</h2>
					
					<?php if (count($estudiantes) > 0) { ?>
						<p>Seleccione un estudiante para ver sus atrasos:</p>
						<div class="estudiantes-grid">
							<?php foreach ($estudiantes as $estudiante) { ?>
								<div class="estudiante-card" onclick="verAtrasos('<?php echo $estudiante['cedula']; ?>')">
									<h3><?php echo $estudiante['nombre']; ?></h3>
									<p>Curso: <?php echo $estudiante['curso']; ?></p>
									<p>Cédula: <?php echo $estudiante['cedula']; ?></p>
								</div>
							<?php } ?>
						</div>
					<?php } else { ?>
						<p style="color: #666;">No se encontraron estudiantes asociados a su cuenta.</p>
						<p style="color: #999; font-size: 14px;">Por favor, contacte al establecimiento si cree que esto es un error.</p>
					<?php } ?>
					
					<hr style="margin: 30px 0; border: 1px solid #ddd;">
					
					<h3>O busque por cédula del estudiante:</h3>
					<form method="GET" action="listar.php" style="margin-top: 15px;">
						<div class="form-group">
							<input type="text" name="cedula" class="form-control" placeholder="Ingrese cédula del estudiante" required>
						</div>
						<button type="submit" class="btn-buscar">🔍 Buscar Atrasos</button>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
	
	<script>
		function verAtrasos(cedula) {
			window.location.href = 'listar.php?cedula=' + cedula;
		}
	</script>
</body>
</html>



