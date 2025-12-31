<?php

function enviarCorreoAsistencia($correo, $asunto, $mensaje) {
    if (!$correo) {
        return false;
    }

    $headers = "From: asistencia@colegio.edu\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    return mail($correo, $asunto, $mensaje, $headers);
}
