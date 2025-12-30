<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

// SOLO POST
if (!isset($_POST['id_estudiante'], $_POST['uid'])) {
    die("Datos incompletos");
}

$id_estudiante = (int) $_POST['id_estudiante'];
$uid = trim($_POST['uid']);

try {
    // 1️⃣ Verificar si UID ya existe
    $stmt = $pdo->prepare(
        "SELECT id_estudiante FROM estudiantes WHERE tarjeta_nfc = ?"
    );
    $stmt->execute([$uid]);

    if ($stmt->fetch()) {
        header("Location: asignar_nfc.php?id=$id_estudiante&error=uid");
        exit;
    }

    // 2️⃣ Verificar si estudiante ya tiene NFC
    $stmt = $pdo->prepare(
        "SELECT tarjeta_nfc FROM estudiantes WHERE id_estudiante = ?"
    );
    $stmt->execute([$id_estudiante]);
    $est = $stmt->fetch();

    if ($est && $est['tarjeta_nfc']) {
        header("Location: asignar_nfc.php?id=$id_estudiante&error=ya_tiene");
        exit;
    }

    // 3️⃣ Guardar NFC
    $stmt = $pdo->prepare(
        "UPDATE estudiantes SET tarjeta_nfc = ? WHERE id_estudiante = ?"
    );
    $stmt->execute([$uid, $id_estudiante]);

    // Éxito
    header("Location: estudiantes_listar.php?ok=nfc");
    exit;

} catch (PDOException $e) {
    die("Error BD: " . $e->getMessage());
}
