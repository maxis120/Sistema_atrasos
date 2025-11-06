-- Tabla para Sistema de Atrasos
-- Base de datos: SistemaAtrasos
-- La tabla tiene 6 campos principales: tipo, cedula, nombre, fecha, hora, motivo

CREATE TABLE IF NOT EXISTS `atrasos` (
  `id_atraso` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('empleado','estudiante') NOT NULL,
  `cedula` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text DEFAULT NULL,
  PRIMARY KEY (`id_atraso`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_cedula` (`cedula`),
  KEY `idx_fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10 registros iniciales con datos textuales correctos
INSERT INTO `atrasos` (`tipo`, `cedula`, `nombre`, `fecha`, `hora`, `motivo`) VALUES
('empleado', '12.345.678-9', 'Juan Pérez González', '2024-01-15', '08:30:00', 'Tráfico pesado en la autopista'),
('estudiante', '98.765.432-1', 'María González Martínez', '2024-01-15', '07:45:00', 'Problemas con el transporte público'),
('empleado', '11.222.333-4', 'Carlos Rodríguez Silva', '2024-01-16', '09:00:00', 'Avería en el vehículo personal'),
('estudiante', '44.333.222-1', 'Ana Martínez López', '2024-01-16', '08:15:00', 'Dificultades para despertar'),
('empleado', '15.678.901-2', 'Pedro Fernández Torres', '2024-01-17', '08:45:00', 'Cita médica de emergencia'),
('estudiante', '22.456.789-3', 'Laura Sánchez Díaz', '2024-01-17', '07:30:00', 'Problemas familiares'),
('empleado', '33.789.012-4', 'Miguel Torres Ramírez', '2024-01-18', '09:15:00', 'Accidente menor en el camino'),
('estudiante', '55.234.567-8', 'Carmen Ruiz Vargas', '2024-01-18', '08:00:00', 'Retraso en el servicio de transporte escolar'),
('empleado', '66.890.123-5', 'Roberto Morales Castro', '2024-01-19', '08:20:00', 'Condiciones climáticas adversas'),
('estudiante', '77.345.678-9', 'Patricia Herrera Jiménez', '2024-01-19', '07:50:00', 'Problemas de salud menores');

