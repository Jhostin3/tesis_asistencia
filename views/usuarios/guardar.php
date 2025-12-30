<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../../config/conexion.php';

$nombres   = trim($_POST['nombres']);
$apellidos = trim($_POST['apellidos']);
$cedula    = trim($_POST['cedula']);
$correo    = trim($_POST['correo']);
$usuario   = trim($_POST['usuario']);
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol       = $_POST['rol'];

try {
    $pdo->beginTransaction();

    $stmtUsuario = $pdo->prepare(
        "INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)"
    );
    $stmtUsuario->execute([$usuario, $password, $rol]);

    $id_usuario = $pdo->lastInsertId();
    $stmtPersonal = $pdo->prepare(
        "INSERT INTO personal (id_usuario, nombres, apellidos, cedula, correo)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmtPersonal->execute([
        $id_usuario,
        $nombres,
        $apellidos,
        $cedula,
        $correo
    ]);

    $pdo->commit();

    header("Location: index.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "❌ Error al guardar el personal: " . $e->getMessage();
}
