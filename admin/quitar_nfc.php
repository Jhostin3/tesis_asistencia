<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_POST['id_estudiante'])) {
    header("Location: estudiantes_listar.php");
    exit;
}

$id = (int) $_POST['id_estudiante'];

$stmt = $pdo->prepare(
    "UPDATE estudiantes SET tarjeta_nfc = NULL WHERE id_estudiante = ?"
);
$stmt->execute([$id]);

header("Location: estudiantes_listar.php?ok=quitado");
exit;
