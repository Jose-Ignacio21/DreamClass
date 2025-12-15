<?php require_once "../includes/auth.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Docente - DreamClass</title>
</head>
<body>
    <h1>👨‍🏫 Panel del Docente</h1>
    <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION["usuario_nombre"]) ?></strong></p>

    <ul>
        <li><a href="#">Gestionar mi disponibilidad</a></li>
        <li><a href="#">Ver mis alumnos</a></li>
        <li><a href="#">Asignar tareas inspiradas en sueños</a></li>
        <li><a href="#">Ver feedback de clases</a></li>
    </ul>

    <p><a href="../logout.php">Cerrar sesión</a></p>
</body>
</html>