<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion || DreamClass</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="procesar_login.php" method="POST">
        <label>Email:<br>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Contraseña:<br>
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>
</body>
</html>