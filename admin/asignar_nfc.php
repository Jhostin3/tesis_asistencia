<?php
session_start();
if (!in_array($_SESSION['rol'], ['admin','secretario'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Asignar tarjeta NFC</title>
<style>
body {
    font-family: Arial, sans-serif;
    text-align: center;
    margin-top: 80px;
}
#estado {
    font-size: 1.4em;
    margin-top: 30px;
}
.uid {
    font-weight: bold;
    color: green;
}
</style>
</head>
<body>

<h2>🪪 Asignar tarjeta NFC</h2>

<p id="estado">🟡 Acerque la tarjeta NFC al lector…</p>

<script>
const raspberryURL = "http://192.168.18.67:5000/leer_nfc";

fetch(raspberryURL)
    .then(res => res.text())
    .then(uid => {
        document.getElementById("estado").innerHTML =
            "✅ Tarjeta detectada: <span class='uid'>" + uid + "</span>";
    })
    .catch(err => {
        document.getElementById("estado").innerHTML =
            "❌ Error al conectar con el lector NFC";
        console.error(err);
    });
</script>

</body>
</html>
