<?php
require_once '../../auth/proteger.php';

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../../config/conexion.php';

$id = $_GET['id'];
$accion = $_GET['accion'];

$estado = ($accion === 'activar') ? 1 : 0;

$stmt = $pdo->prepare(
    "UPDATE usuarios SET estado = ? WHERE id_usuario = ?"
);
$stmt->execute([$estado, $id]);

header("Location: index.php");
exit;
