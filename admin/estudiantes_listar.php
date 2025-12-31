<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

/*
 Traemos estudiantes + usuario (si existe)
 LEFT JOIN para que aparezcan aunque no tengan usuario
*/
$stmt = $pdo->query(
    "SELECT e.*, u.usuario
     FROM estudiantes e
     LEFT JOIN usuarios u ON u.id_estudiante = e.id_estudiante
     ORDER BY e.apellidos"
);
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

<a href="estudiantes_crear.php">➕ Nuevo estudiante</a>
<br><br>

<table border="1" cellpadding="5">
<tr>
    <th>Nombre</th>
    <th>Curso</th>
    <th>Cédula</th>
    <th>NFC</th>
    <th>Estado</th>
    <th>Usuario</th>
    <th>Acción</th>
</tr>

<?php foreach ($estudiantes as $e): ?>
<tr>
    <td><?= $e['nombres'].' '.$e['apellidos'] ?></td>
    <td><?= $e['curso'] ?></td>
    <td><?= $e['cedula'] ?></td>
    <td><?= $e['tarjeta_nfc'] ?: 'No asignada' ?></td>
    <td><?= $e['estado'] ?></td>

    <!-- USUARIO -->
    <td>
        <?php if ($e['usuario']): ?>
            <?= $e['usuario'] ?>
        <?php else: ?>
            <a href="usuarios/crear_estudiante.php?id=<?= $e['id_estudiante'] ?>">
                ➕ Crear usuario
            </a>
        <?php endif; ?>
    </td>

    <!-- ACCIONES -->
    <td>

        <!-- NFC -->
        <?php if ($e['tarjeta_nfc']): ?>
            <form method="POST" action="quitar_nfc.php" style="display:inline;">
                <input type="hidden" name="id_estudiante" value="<?= $e['id_estudiante'] ?>">
                <button type="submit">Quitar NFC</button>
            </form>
        <?php else: ?>
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
<!-- 🔁 VOLVER CORRECTO SEGÚN ROL -->
<a href="../views/index.php">⬅ Volver al dashboard</a>

</body>
</html>
