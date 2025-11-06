<?php
session_start();
include("conexion.php");
error_reporting(0);

$mensaje = "";

// Verificar si ya está logueado
if (isset($_SESSION['tipo_usuario'])) {
    header("Location: index.php");
    exit;
}

// Procesar login
if ($_POST['btn_login']) {
    $tipo = $_POST['tipo_usuario'];
    $cedula = $_POST['txt_cedula'];
    $clave = $_POST['txt_clave'];
    
    if ($tipo == 'funcionario') {
        // Verificar funcionario (contraseña simple: "funcionario123")
        if ($clave == 'funcionario123') {
            $_SESSION['tipo_usuario'] = 'funcionario';
            $_SESSION['cedula'] = $cedula;
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Contraseña incorrecta para funcionarios";
        }
    } elseif ($tipo == 'padre' || $tipo == 'estudiante') {
        // Verificar padre/apoderado (contraseña simple: "padre123")
        if ($clave == 'padre123' || $clave == 'estudiante123') {
            $_SESSION['tipo_usuario'] = 'padre';
            $_SESSION['cedula'] = $cedula;
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Contraseña incorrecta para padres/apoderados";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Atrasos - Login</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body {
			font-family: Arial, sans-serif;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			padding: 20px;
		}
		.login-container {
			background: white;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.3);
			width: 100%;
			max-width: 400px;
		}
		h1 {
			text-align: center;
			color: #333;
			margin-bottom: 30px;
			font-size: 28px;
		}
		.form-group {
			margin-bottom: 20px;
		}
		label {
			display: block;
			margin-bottom: 8px;
			color: #555;
			font-weight: bold;
		}
		select, input[type="text"], input[type="password"] {
			width: 100%;
			padding: 12px;
			border: 2px solid #ddd;
			border-radius: 5px;
			font-size: 16px;
			transition: border-color 0.3s;
		}
		select:focus, input:focus {
			outline: none;
			border-color: #667eea;
		}
		.btn {
			width: 100%;
			padding: 12px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			border: none;
			border-radius: 5px;
			font-size: 16px;
			cursor: pointer;
			transition: transform 0.2s;
		}
		.btn:hover {
			transform: translateY(-2px);
		}
		.mensaje {
			background: #ff6b6b;
			color: white;
			padding: 12px;
			border-radius: 5px;
			margin-bottom: 20px;
			text-align: center;
		}
		.info {
			background: #e3f2fd;
			padding: 15px;
			border-radius: 5px;
			margin-top: 20px;
			font-size: 14px;
			color: #1976d2;
		}
		.info strong {
			display: block;
			margin-bottom: 5px;
		}
	</style>
</head>
<body>
	<div class="login-container">
		<h1>🔐 Sistema de Atrasos</h1>
		
		<?php if ($mensaje != "") { ?>
			<div class="mensaje"><?php echo $mensaje; ?></div>
		<?php } ?>
		
		<form name="form_login" method="post" action="login.php">
			<div class="form-group">
				<label for="tipo_usuario">Tipo de Usuario:</label>
				<select name="tipo_usuario" id="tipo_usuario" required>
					<option value="">Seleccione...</option>
					<option value="padre">Padre/Apoderado</option>
					<option value="funcionario">Funcionario</option>
				</select>
			</div>
			
			<div class="form-group">
				<label for="txt_cedula">Cédula/RUT:</label>
				<input type="text" name="txt_cedula" id="txt_cedula" placeholder="Ingrese su cédula" required>
			</div>
			
			<div class="form-group">
				<label for="txt_clave">Contraseña:</label>
				<input type="password" name="txt_clave" id="txt_clave" placeholder="Ingrese su contraseña" required>
			</div>
			
			<button type="submit" name="btn_login" value="1" class="btn">Ingresar</button>
		</form>
		
		<div class="info">
			<strong>Contraseñas de acceso:</strong>
			Funcionarios: <strong>funcionario123</strong><br>
			Padres/Apoderados: <strong>padre123</strong>
		</div>
	</div>
</body>
</html>

