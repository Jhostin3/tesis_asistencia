<?php
session_start();

if (!in_array($_SESSION['rol'], ['admin','inspector','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de asistencia NFC</title>
</head>
<body>

<h2>📋 Registro de asistencia</h2>

<p id="estado">🟡 Acerque su tarjeta NFC al lector…</p>

<script>
const raspberryURL = "http://192.168.18.67:5000/leer_nfc";
const guardarURL = "guardar_asistencia.php";

fetch(raspberryURL)
    .then(res => res.text())
    .then(uid => {
        document.getElementById("estado").innerText =
            "🟢 Tarjeta detectada. Procesando...";

        // Enviar UID al backend
        fetch(guardarURL, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "uid=" + uid
        })
        .then(res => res.text())
        .then(msg => {
            document.getElementById("estado").innerText = msg;
        });
    })
    .catch(() => {
        document.getElementById("estado").innerText =
            "❌ Error al conectar con el lector NFC";
    });
</script>

<br>
<a href="../views/dashboard_admin.php">⬅ Volver</a>

</body>
</html>
