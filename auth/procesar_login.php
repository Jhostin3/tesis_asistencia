<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario  = trim($_POST['usuario']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare(
        "SELECT * FROM usuarios WHERE usuario = ? AND estado = 1"
    );
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        // SESIONES BASE
        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['usuario']    = $user['usuario'];
        $_SESSION['rol']        = $user['rol'];

        if ($user['rol'] === 'estudiante') {
            $_SESSION['id_estudiante'] = $user['id_estudiante'];
        }

        header("Location: ../views/index.php");
        exit;

    } else {
        echo "❌ Usuario o contraseña incorrectos";
    }
}
