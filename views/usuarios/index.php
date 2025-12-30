<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../../config/conexion.php';

$stmt = $pdo->query("
    SELECT u.id_usuario, u.usuario, u.rol, u.estado,
           p.nombres, p.apellidos
    FROM usuarios u
    JOIN personal p ON u.id_usuario = p.id_usuario
");
$usuarios = $stmt->fetchAll();
?>

<h2>Gestión de Usuarios</h2>

<a href="crear.php">➕ Crear nuevo usuario</a>
<br><br>

<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?= $u['nombres'] . ' ' . $u['apellidos'] ?></td>
        <td><?= $u['usuario'] ?></td>
        <td><?= $u['rol'] ?></td>
        <td><?= $u['estado'] ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <?php if ($u['estado']): ?>
                <a href="estado.php?id=<?= $u['id_usuario'] ?>&accion=desactivar">
                    🚫 Desactivar
                </a>
            <?php else: ?>
                <a href="estado.php?id=<?= $u['id_usuario'] ?>&accion=activar">
                    ✅ Activar
                </a>
            <?php endif; ?>

            | <a href="rol.php?id=<?= $u['id_usuario'] ?>">🔄 Cambiar rol</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="../dashboard_admin.php">⬅ Volver al dashboard</a>