<?php
require_once '../../config/conexion.php';
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST['id_estudiante'], $_POST['usuario'], $_POST['password'])) {
    die("Datos incompletos");
}

$id_estudiante = (int) $_POST['id_estudiante'];
$usuario = trim($_POST['usuario']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare(
        "INSERT INTO usuarios (usuario, password, rol, id_estudiante)
         VALUES (?, ?, 'estudiante', ?)"
    );
    $stmt->execute([$usuario, $password, $id_estudiante]);

    // 🔁 REDIRECCIÓN OBLIGATORIA
    header("Location: ../estudiantes_listar.php?ok=usuario");
    exit;

} catch (PDOException $e) {
    die("Error al crear usuario: " . $e->getMessage());
}
