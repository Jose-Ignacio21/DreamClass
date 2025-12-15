<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header('Location: ../login.php?error=Necesitas iniciar sesión');
    exit;
}

// Si esta página es de docente, verificar rol
if (basename(dirname(__FILE__)) === "docente" && $_SESSION["usuario_rol"] !== "docente") {
    header('Location: ../login.php?error=Acceso denegado: no eres docente');
    exit;
}

// Si esta página es de alumno, verificar rol
if (basename(dirname(__FILE__)) === "alumno" && $_SESSION["usuario_rol"] !== "alumno") {
    header('Location: ../login.php?error=Acceso denegado: no eres alumno');
    exit;
}
?>