<?php
session_start();

if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: estudiantes_listar.php");
    exit;
}

$id_estudiante = (int) $_GET['id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Asignar tarjeta NFC</title>
</head>
<body>

<h2>Asignar tarjeta NFC</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === 'uid'): ?>
<p>❌ Esta tarjeta NFC ya está asignada a otro estudiante.</p>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'ya_tiene'): ?>
<p>❌ Este estudiante ya tiene una tarjeta asignada.</p>
<?php endif; ?>

<p id="estado">Acerque la tarjeta NFC al lector…</p>

<form method="POST" action="guardar_nfc.php">
    <input type="hidden" name="id_estudiante" value="<?= $id_estudiante ?>">
    <input type="hidden" name="uid" id="uid">
    <button type="submit" id="btnGuardar" style="display:none;">
        Guardar tarjeta NFC
    </button>
</form>

<script>
const raspberryURL = "http://192.168.18.67:5000/leer_nfc";

fetch(raspberryURL)
    .then(res => res.text())
    .then(uid => {
        document.getElementById("estado").innerText =
            "Tarjeta detectada: " + uid;

        document.getElementById("uid").value = uid;
        document.getElementById("btnGuardar").style.display = "inline";
    })
    .catch(() => {
        document.getElementById("estado").innerText =
            "Error al conectar con el lector NFC";
    });
</script>

<br>
<a href="estudiantes_listar.php">⬅ Volver</a>

</body>
</html>
