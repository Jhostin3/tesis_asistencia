<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','inspector','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_POST['uid'])) {
    die("UID no recibido");
}

$uid = trim($_POST['uid']);

try {
    // 1️⃣ Buscar estudiante activo por NFC
    $stmt = $pdo->prepare(
        "SELECT id_estudiante, nombres, apellidos
         FROM estudiantes
         WHERE tarjeta_nfc = ? AND estado = 'activo'"
    );
    $stmt->execute([$uid]);
    $est = $stmt->fetch();

    if (!$est) {
        echo "❌ Tarjeta no registrada o estudiante inactivo";
        exit;
    }

    $id_estudiante = $est['id_estudiante'];

    // 2️⃣ Verificar si ya marcó hoy
    $stmt = $pdo->prepare(
        "SELECT id_asistencia
         FROM asistencias
         WHERE id_estudiante = ?
         AND fecha = CURDATE()"
    );
    $stmt->execute([$id_estudiante]);

    if ($stmt->fetch()) {
        echo "⚠️ Asistencia ya registrada hoy";
        exit;
    }

    // 3️⃣ Registrar asistencia (fecha y hora separadas)
    $stmt = $pdo->prepare(
        "INSERT INTO asistencias (id_estudiante, fecha, hora, estado)
         VALUES (?, CURDATE(), CURTIME(), 'presente')"
    );
    $stmt->execute([$id_estudiante]);

    echo "✅ Asistencia registrada: {$est['nombres']} {$est['apellidos']}";

} catch (PDOException $e) {
    echo "❌ Error BD: " . $e->getMessage();
}
