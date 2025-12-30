<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Asistencia</title>
</head>
<body>

<h2>Iniciar sesión</h2>

<form action="procesar_login.php" method="POST">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Ingresar</button>
</form>

</body>
</html>
