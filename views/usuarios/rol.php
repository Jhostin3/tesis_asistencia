<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../../config/conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT usuario, rol FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<h2>Cambiar rol</h2>

<p>Usuario: <strong><?= $user['usuario'] ?></strong></p>

<form action="rol_guardar.php" method="POST">
    <input type="hidden" name="id_usuario" value="<?= $id ?>">

    <select name="rol">
        <option value="admin" <?= $user['rol']=='admin'?'selected':'' ?>>Administrador</option>
        <option value="inspector" <?= $user['rol']=='inspector'?'selected':'' ?>>Inspector</option>
        <option value="secretario" <?= $user['rol']=='secretario'?'selected':'' ?>>Secretario</option>
    </select>

    <br><br>
    <button type="submit">Guardar cambios</button>
</form>

<a href="index.php">⬅ Volver</a>
