<?php
session_start();
require_once '../config/conexion.php';

// ✅ Permitir admin e inspector
if (!isset($_SESSION['usuario']) || 
    !in_array($_SESSION['rol'], ['admin', 'inspector'])) {
    header("Location: ../auth/login.php");
    exit;
}

// ✅ Capturar filtro de curso
$curso = $_GET['curso'] ?? '';

// Consulta base
$sql = "
SELECT a.*, e.nombres, e.apellidos, e.curso
FROM asistencias a
INNER JOIN estudiantes e ON e.id_estudiante = a.id_estudiante
WHERE a.fecha = CURDATE()
";

$params = [];

// ✅ Aplicar filtro si existe
if (!empty($curso)) {
    $sql .= " AND e.curso LIKE ?";
    $params[] = "%$curso%";
}

$sql .= " ORDER BY a.hora ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$asistencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard Inspector</title>
</head>
<body>

<h1>Dashboard <?= ucfirst($_SESSION['rol']) ?> 🕵️‍♂️</h1>

<p>Bienvenido <?= $_SESSION['usuario'] ?></p>
<a href="../auth/logout.php">Cerrar sesión</a>

<hr>

<h3>Asistencias del día (<?= date('Y-m-d') ?>)</h3>

<!-- ✅ FORMULARIO DE FILTRO -->
<form method="GET" style="margin-bottom:15px;">
    <label>Filtrar por curso:</label>
    <input type="text" name="curso" placeholder="Ej: 3E1"
           value="<?= htmlspecialchars($curso) ?>">
    <button type="submit">Buscar</button>
    <a href="dashboard_inspector.php">Limpiar</a>
</form>

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
    <td colspan="5">No hay asistencias registradas</td>
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

<?php if ($_SESSION['rol'] === 'admin'): ?>
    <a href="../admin/asistencia_nfc.php">📋 Registrar asistencia (NFC)</a>
<?php endif; ?>

</body>
</html>
