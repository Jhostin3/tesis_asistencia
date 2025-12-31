<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$id_estudiante = $_GET['id'];
?>

<h2>Crear usuario estudiante</h2>

<form action="guardar_estudiante.php" method="POST">

    <input type="hidden" name="id_estudiante" value="<?= $id_estudiante ?>">

    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Crear usuario estudiante</button>
</form>

<a href="../estudiantes_listar.php">⬅ Volver</a>
