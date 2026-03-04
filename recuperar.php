<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña || DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-2">Recuperar Acceso</h2>
        <p class="text-gray-500 text-sm text-center mb-6">Introduce el email de tu cuenta y te enviaremos una contraseña temporal.</p>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded text-sm">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>procesar_recuperacion" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" required placeholder="tu@email.com"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">
                Enviar Contraseña
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            ¿La has recordado? <a href="<?= BASE_URL ?>login" class="text-blue-600 font-bold hover:underline">Vuelve al Login</a>
        </p>
    </div>
</body>
</html>