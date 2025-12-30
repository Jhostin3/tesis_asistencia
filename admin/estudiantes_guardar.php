<?php
session_start();
require_once '../config/conexion.php';

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

try {
    $sql = "INSERT INTO estudiantes 
    (nombres, apellidos, cedula, correo, telefono_padre, telefono_madre)
    VALUES (?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombres'],
        $_POST['apellidos'],
        $_POST['cedula'],
        $_POST['correo'],
        $_POST['telefono_padre'],
        $_POST['telefono_madre']
    ]);

    header("Location: estudiantes_crear.php?ok=1");
    exit;

} catch (PDOException $e) {

    if ($e->getCode() == 23000) {
        header("Location: estudiantes_crear.php?error=cedula");
        exit;
    }
    echo "Error inesperado: " . $e->getMessage();
}
