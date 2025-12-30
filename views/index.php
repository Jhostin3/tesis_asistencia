<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: ../auth/login.php");
    exit;
}

switch ($_SESSION['rol']) {

    case 'admin':
        header("Location: dashboard_admin.php");
        break;

    case 'inspector':
        header("Location: dashboard_inspector.php");
        break;

    case 'secretario':
        header("Location: dashboard_secretario.php");
        break;

    case 'estudiante':
        header("Location: dashboard_estudiante.php");
        break;

    default:
        session_destroy();
        header("Location: ../auth/login.php");
        break;
}

exit;
