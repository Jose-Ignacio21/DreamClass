<?php
session_start();
require_once "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit;
}

$nombre = trim($_POST["nombre"] ?? '');
$email = trim($_POST["email"] ?? '');
$rol = $_POST["rol"] ?? '';
$password = $_POST["password"] ?? '';

// Validaciones básicas
// Si el usuario no introduce datos en los inputs
if (empty($nombre) || empty($email) || empty($rol) || empty($password)) {
    header('Location: registro.php?error=Faltan datos obligatorios');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?error=Email inválido');
    exit;
}

if ($rol !== 'docente' && $rol !== 'alumno') {
    header('Location: registro.php?error=Rol no válido');
    exit;
}

if (strlen($password) < 8) {
    header('Location: registro.php?error=La contraseña debe tener al menos 8 caracteres');
    exit;
}

// Verificar si el email ya existe
$stmt = $pdo->prepare("SELECT id_usuario FROM Usuario WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header('Location: registro.php?error=Este email ya está registrado');
    exit;
}

// Hashear la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertar en Usuario
$stmt = $pdo->prepare("INSERT INTO Usuario (nombre, email, contrasenia, rol) VALUES (?, ?, ?, ?)");
try {
    $stmt->execute([$nombre, $email, $hashedPassword, $rol]);
    $id_usuario = $pdo->lastInsertId();

    // Crear perfil en subtabla (Docente o Alumno)
    if ($rol === 'docente') {
        $stmt = $pdo->prepare("INSERT INTO Docente (id_docente) VALUES (?)");
        $stmt->execute([$id_usuario]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO Alumno (id_alumno) VALUES (?)");
        $stmt->execute([$id_usuario]);
    }

    header('Location: registro.php?success=¡Registro completado! Ahora inicia sesión.');
    exit;

}catch (Exception $e) {
    error_log("Error en registro: " . $e->getMessage());
    header('Location: register.php?error=Error al registrar. Inténtalo más tarde.');
    exit;

}