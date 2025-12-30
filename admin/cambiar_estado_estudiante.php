<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_POST['id_estudiante'], $_POST['estado'])) {
    header("Location: estudiantes_listar.php");
    exit;
}

$id = (int) $_POST['id_estudiante'];
$nuevo_estado = $_POST['estado'] === 'activo' ? 'activo' : 'inactivo';

$stmt = $pdo->prepare(
    "UPDATE estudiantes SET estado = ? WHERE id_estudiante = ?"
);
$stmt->execute([$nuevo_estado, $id]);

header("Location: estudiantes_listar.php?ok=estado");
exit;
