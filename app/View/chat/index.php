<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($datos['titulo']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">

    <?php if ($datos['rol'] === 'docente'): ?>
        <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>
    <?php else: ?>
        <?php include __DIR__ . '/../layout/sidebar_alumno.php'; ?>
    <?php endif; ?>

    <main class="flex-1 p-6 max-w-6xl w-full">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><?= htmlspecialchars($datos['titulo_contactos']) ?></h2>

            <?php if ($datos['error']): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <?= htmlspecialchars($datos['error']) ?>
                </div>
            <?php endif; ?>

            <?php if (empty($datos['contactos'])): ?>
                <p class="text-gray-600">
                    No tienes contactos disponibles.
                    <?php if ($datos['rol'] === 'alumno'): ?>
                        <a href="<?= BASE_URL ?>clases/crear" class="text-blue-600 hover:underline">Reserva una clase primero</a>.
                    <?php endif; ?>
                </p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($datos['contactos'] as $c): ?>
                        <a href="<?= BASE_URL ?>mensajes/ver?id=<?= $c['id_usuario'] ?>" 
                           class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <div class="bg-blue-100 text-blue-800 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                                    <span>👤</span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900"><?= htmlspecialchars($c['nombre']) ?></h3>
                                    <p class="text-sm text-gray-500">Haz clic para abrir la conversación</p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>