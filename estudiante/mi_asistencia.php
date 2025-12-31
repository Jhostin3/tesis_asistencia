<?php
session_start();
require_once '../config/conexion.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../auth/login.php");
    exit;
}

// Asumimos que al iniciar sesión guardaste el id_estudiante
$id_estudiante = $_SESSION['id_estudiante'];

$stmt = $pdo->prepare(
    "SELECT fecha, hora, hora_salida
     FROM asistencias
     WHERE id_estudiante = ?
     ORDER BY fecha DESC, hora DESC"
);
$stmt->execute([$id_estudiante]);
$asistencias = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi asistencia</title>
</head>
<body>

<h1>📅 Mi asistencia</h1>

<a href="../views/dashboard_estudiante.php">⬅ Volver</a>
<br><br>

<table border="1" cellpadding="5">
<tr>
    <th>Fecha</th>
    <th>Hora de entrada</th>
    <th>Hora de salida</th>
</tr>

<?php if (!$asistencias): ?>
<tr>
    <td colspan="3">No hay registros de asistencia.</td>
</tr>
<?php endif; ?>

<?php foreach ($asistencias as $a): ?>
<tr>
    <td><?= $a['fecha'] ?></td>
    <td><?= $a['hora'] ?></td>
    <td><?= $a['hora_salida'] ?? '—' ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
