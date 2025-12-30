<?php
session_start();

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar estudiante</title>
</head>
<body>

<h2>Registrar estudiante</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === 'cedula'): ?>
    <p>⚠️ Ya existe un estudiante registrado con esa cédula.</p>
<?php endif; ?>

<?php if (isset($_GET['ok'])): ?>
    <p>✅ Estudiante registrado correctamente.</p>
<?php endif; ?>

<form action="estudiantes_guardar.php" method="POST">

    <input type="text" name="nombres" placeholder="Nombres" required>
    <br><br>

    <input type="text" name="apellidos" placeholder="Apellidos" required>
    <br><br>

    <input type="text" name="cedula" placeholder="Cédula" required>
    <br><br>

    <input type="email" name="correo" placeholder="Correo">
    <br><br>

    <input type="text" name="telefono_padre" placeholder="Teléfono del padre">
    <br><br>

    <input type="text" name="telefono_madre" placeholder="Teléfono de la madre">
    <br><br>
    <input type="text" name="curso" placeholder="Curso (ej: 3E1)" required>
    <br><br>

    <button type="submit">Guardar estudiante</button>
</form>

<br>
<a href="estudiantes_listar.php">📋 Ver lista de estudiantes</a>

</body>
</html>
