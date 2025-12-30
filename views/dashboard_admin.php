<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<h1>Dashboard Admin 😎</h1>
<p>Bienvenido <?= $_SESSION['usuario'] ?></p>
<p>Rol: <?= $_SESSION['rol'] ?></p>
<a href="../auth/logout.php">Cerrar sesión</a>
<br><br>
<a href="usuarios/index.php">👥 Gestión de usuarios</a>
