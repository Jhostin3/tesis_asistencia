<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM estudiantes ORDER BY apellidos");
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de estudiantes</title>
</head>
<body>

<h2>Estudiantes registrados</h2>

<a href="estudiantes_crear.php">+ Nuevo estudiante</a>

<table border="1" cellpadding="5">
<tr>
    <th>Nombre</th>
    <th>Cédula</th>
    <th>NFC</th>
</tr>

<?php foreach ($estudiantes as $e): ?>
<tr>
    <td><?= $e['nombres'].' '.$e['apellidos'] ?></td>
    <td><?= $e['cedula'] ?></td>
    <td><?= $e['tarjeta_nfc'] ?? 'No asignada' ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
