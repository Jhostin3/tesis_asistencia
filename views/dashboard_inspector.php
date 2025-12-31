<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'inspector') {
    header("Location: ../auth/login.php");
    exit;
}

// Traer asistencias del día
$stmt = $pdo->prepare(
    "SELECT a.*, e.nombres, e.apellidos, e.curso
     FROM asistencias a
     INNER JOIN estudiantes e ON e.id_estudiante = a.id_estudiante
     WHERE a.fecha = CURDATE()
     ORDER BY a.hora ASC"
);
$stmt->execute();
$asistencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard Inspector</title>
</head>
<body>

<h1>Dashboard Inspector 🕵️‍♂️</h1>

<p>Bienvenido <?= $_SESSION['usuario'] ?></p>
<a href="../auth/logout.php">Cerrar sesión</a>

<hr>

<h3>Asistencias del día (<?= date('Y-m-d') ?>)</h3>

<table border="1" cellpadding="5">
<tr>
    <th>Estudiante</th>
    <th>Curso</th>
    <th>Hora entrada</th>
    <th>Hora salida</th>
    <th>Estado</th>
</tr>

<?php if (count($asistencias) === 0): ?>
<tr>
    <td colspan="5">No hay asistencias registradas hoy</td>
</tr>
<?php endif; ?>

<?php foreach ($asistencias as $a): ?>
<tr>
    <td><?= $a['nombres'].' '.$a['apellidos'] ?></td>
    <td><?= $a['curso'] ?></td>
    <td><?= $a['hora'] ?></td>
    <td><?= $a['hora_salida'] ?: '—' ?></td>
    <td><?= $a['estado'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<br>

<a href="../admin/asistencia_nfc.php">📋 Registrar asistencia (NFC)</a>

</body>
</html>
