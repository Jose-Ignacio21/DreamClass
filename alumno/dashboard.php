<?php require_once '../includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Alumno - DreamClass</title>
</head>
<body>
    <h1>🧑‍🎓 Panel del Alumno</h1>
    <p>Hola, <strong><?= htmlspecialchars($_SESSION["usuario_nombre"]) ?></strong></p>

    <ul>
        <li><a href="#">Reservar una clase</a></li>
        <li><a href="#">Ver mis tareas pendientes</a></li>
        <li><a href="#">Chat con mi docente</a></li>
        <li><a href="#">Dejar feedback</a></li>
    </ul>

    <p><a href="../logout.php">Cerrar sesión</a></p>
</body>
</html>