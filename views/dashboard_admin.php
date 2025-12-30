<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
</head>
<body>

<h1>Dashboard Admin 😎</h1>

<p>Bienvenido <?= $_SESSION['usuario'] ?></p>
<p>Rol: <?= $_SESSION['rol'] ?></p>

<a href="../auth/logout.php">Cerrar sesión</a>

<hr>

<h3>Gestión</h3>

<ul>
    <li><a href="usuarios/index.php">👥 Gestión de usuarios</a></li>
    <li><a href="../admin/estudiantes_listar.php">🎓 Gestión de estudiantes</a></li>
    <li><a href="../admin/asistencia_nfc.php">📋 Registrar asistencia (NFC)</a></li>
</ul>

</body>
</html>
