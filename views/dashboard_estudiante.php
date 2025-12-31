<?php
session_start();

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard Estudiante</title>
</head>
<body>

<h1>Mi panel 🎓</h1>

<p>Estudiante: <?= $_SESSION['usuario'] ?></p>

<a href="../auth/logout.php">Cerrar sesión</a>

<hr>

<ul>
    <li><a href="../estudiante/mi_asistencia.php">📅 Mi asistencia</a></li>
</ul>

</body>
</html>
