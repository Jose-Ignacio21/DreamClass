<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro || DreamClass</title>
</head>
<body>
    <h2>Crear cuenta</h2>
    <form action="procesar_registro.php" method="POST">
        <label>Nombre:<br>
            <input type="text" name="nombre" required>
        </label><br><br>

        <label>Email:<br>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Rol:<br>
            <select name="rol" required>
                <option value="">-- Selecciona --</option>
                <option value="docente">Docente</option>
                <option value="alumno">Alumno</option>
            </select>
        </label><br><br>

        <label>Contraseña:<br>
            <input type="password" name="password" minlength="8" required>
        </label><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

    <?php
    if (isset($_GET["error"])) {
        echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    if (isset($_GET["success"])) {
        echo "<p style='color:green;'>" . htmlspecialchars($_GET['success']) . "</p>";
    }
    ?>
</body>
</html>