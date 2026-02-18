<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión || DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Iniciar sesión</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="procesar_login" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                Entrar
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            ¿No tienes cuenta? <a href="<?= BASE_URL ?>registro" class="text-blue-600 hover:underline">Regístrate</a>
        </p>

        <p class="mt-4 text-center text-gray-600">
            <a href="<?= BASE_URL ?>" class="text-blue-600 hover:underline">Volver</a>
        </p>
    </div>
</body>
</html>