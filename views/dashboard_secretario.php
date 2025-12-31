<?php
session_start();

if ($_SESSION['rol'] !== 'secretario') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard Secretario</title>
</head>
<body>

<h1>Dashboard Secretario 🗂️</h1>

<p>Bienvenido <?= $_SESSION['usuario'] ?></p>

<a href="../auth/logout.php">Cerrar sesión</a>

<hr>

<ul>
    <li><a href="../admin/estudiantes_listar.php">🎓 Gestión de estudiantes</a></li>
    <li><a href="../admin/asignar_nfc.php">🪪 Asignar tarjeta NFC</a></li>
    <li><a href="../admin/asistencia_nfc.php">📋 Registrar asistencia</a></li>
</ul>

</body>
</html>
