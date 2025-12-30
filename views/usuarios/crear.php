<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>

<h2>Crear nuevo personal</h2>

<form action="guardar.php" method="POST">

    <label>Nombres:</label><br>
    <input type="text" name="nombres" required><br><br>

    <label>Apellidos:</label><br>
    <input type="text" name="apellidos" required><br><br>

    <label>Cédula:</label><br>
    <input type="text" name="cedula" maxlength="10" required><br><br>

    <label>Correo:</label><br>
    <input type="email" name="correo"><br><br>

    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Rol:</label><br>
    <select name="rol" required>
        <option value="admin">Administrador</option>
        <option value="inspector">Inspector</option>
        <option value="secretario">Secretario</option>
    </select><br><br>

    <button type="submit">Guardar</button>
</form>

<br>
<a href="index.php">⬅ Volver</a>
