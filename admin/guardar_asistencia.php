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

    // 2️⃣ Buscar asistencia de HOY
    $stmt = $pdo->prepare(
        "SELECT id_asistencia, hora_salida
         FROM asistencias
         WHERE id_estudiante = ?
         AND fecha = CURDATE()
         ORDER BY id_asistencia DESC
         LIMIT 1"
    );
    $stmt->execute([$id_estudiante]);
    $asistencia = $stmt->fetch();

    // 3️⃣ NO existe asistencia hoy → ENTRADA
    if (!$asistencia) {
        $stmt = $pdo->prepare(
            "INSERT INTO asistencias (id_estudiante, fecha, hora, estado)
             VALUES (?, CURDATE(), CURTIME(), 'presente')"
        );
        $stmt->execute([$id_estudiante]);

        echo "🟢 Entrada registrada: {$est['nombres']} {$est['apellidos']}";
        exit;
    }

    // 4️⃣ Existe entrada pero NO salida → SALIDA
    if ($asistencia['hora_salida'] === null) {
        $stmt = $pdo->prepare(
            "UPDATE asistencias
             SET hora_salida = CURTIME()
             WHERE id_asistencia = ?"
        );
        $stmt->execute([$asistencia['id_asistencia']]);

        echo "🔵 Salida registrada: {$est['nombres']} {$est['apellidos']}";
        exit;
    }

    // 5️⃣ Entrada y salida ya registradas
    echo "⚠️ Asistencia completa del día";

} catch (PDOException $e) {
    echo "❌ Error BD: " . $e->getMessage();
}
