<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST["email"] ?? '');
$password = $_POST["password"] ?? '';

if (empty($email) || empty($password)) {
    header('Location: login.php?error=Completa todos los campos');
    exit;
}

// Buscar usuario
$stmt = $pdo->prepare("SELECT id_usuario, nombre, email, contrasenia, rol FROM Usuario WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario["contrasenia"])) {
    header('Location: login.php?error=Email o contraseña incorrectos');
    exit;
}

// Iniciar sesión
$_SESSION["usuario_id"] = $usuario["id_usuario"];
$_SESSION["usuario_nombre"] = $usuario["nombre"];
$_SESSION["usuario_rol"] = $usuario["rol"];

// Redirigir según rol
if ($usuario['rol'] === 'docente') {
    header('Location: docente/dashboard.php'); // Crearemos un dashboard para cada rol
} elseif ($usuario['rol'] === 'alumno') {
    header('Location: alumno/dashboard.php');
} else {
    header('Location: admin/dashboard.php');
}
exit;