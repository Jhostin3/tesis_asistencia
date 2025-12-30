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
<br><br>

<table border="1" cellpadding="5">
<tr>
    <th>Nombre</th>
    <th>Cédula</th>
    <th>NFC</th>
    <th>Estado</th>
    <th>Acción</th>
</tr>

<?php foreach ($estudiantes as $e): ?>
<tr>
    <td><?= $e['nombres'].' '.$e['apellidos'] ?></td>
    <td><?= $e['cedula'] ?></td>
    <td><?= $e['tarjeta_nfc'] ? $e['tarjeta_nfc'] : 'No asignada' ?></td>
    <td><?= $e['estado'] ?></td>
    <td>

        <?php if ($e['tarjeta_nfc']): ?>
            <!-- Quitar NFC -->
            <form method="POST" action="quitar_nfc.php" style="display:inline;">
                <input type="hidden" name="id_estudiante" value="<?= $e['id_estudiante'] ?>">
                <button type="submit">Quitar NFC</button>
            </form>
        <?php else: ?>
            <!-- Asignar NFC -->
            <a href="asignar_nfc.php?id=<?= $e['id_estudiante'] ?>">
                Asignar NFC
            </a>
        <?php endif; ?>

        <!-- Activar / Desactivar -->
        <form method="POST" action="cambiar_estado_estudiante.php" style="display:inline;">
            <input type="hidden" name="id_estudiante" value="<?= $e['id_estudiante'] ?>">
            <input type="hidden" name="estado"
                   value="<?= $e['estado'] === 'activo' ? 'inactivo' : 'activo' ?>">
            <button type="submit">
                <?= $e['estado'] === 'activo' ? 'Desactivar' : 'Activar' ?>
            </button>
        </form>

    </td>
</tr>
<?php endforeach; ?>

</table>

<br>
<a href="../views/dashboard_admin.php">⬅ Volver al dashboard</a>

</body>
</html>
