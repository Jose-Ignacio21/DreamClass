<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/'); 
}

function verificarAutenticacion() {
    if (!isset($_SESSION["usuario_id"])) {
        header('Location: ' . BASE_URL . 'login?error=Necesitas iniciar sesión');
        exit;
    }
}

function verificarRol($rol_requerido) {
    verificarAutenticacion();
    
    if ($_SESSION["usuario_rol"] !== $rol_requerido) {
        header('Location: ' . BASE_URL . 'login?error=Acceso denegado: no tienes permisos');
        exit;
    }
}
?>