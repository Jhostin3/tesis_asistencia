<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../../config/conexion.php';

$id = $_POST['id_usuario'];
$rol = $_POST['rol'];

$stmt = $pdo->prepare(
    "UPDATE usuarios SET rol = ? WHERE id_usuario = ?"
);
$stmt->execute([$rol, $id]);

header("Location: index.php");
exit;
