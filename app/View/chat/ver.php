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
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Chat con <?= htmlspecialchars($datos['contacto_nombre']) ?></h2>
                <a href="<?= BASE_URL ?>mensajes" class="text-sm text-blue-600 hover:underline">Volver a chats</a>
            </div>

            <div class="h-96 overflow-y-auto mb-6 p-4 bg-gray-50 rounded-lg border">
                <?php if (empty($datos['mensajes'])): ?>
                    <p class="text-gray-500 text-center py-8">No hay mensajes aún.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($datos['mensajes'] as $msg): ?>
                            <div class="flex <?= $msg['id_remitente'] == $_SESSION['usuario_id'] ? 'justify-end' : 'justify-start' ?>">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg <?= $msg['id_remitente'] == $_SESSION['usuario_id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' ?>">
                                    <p><?= htmlspecialchars($msg['contenido']) ?></p>
                                    <div class="text-xs mt-1 opacity-80">
                                        <?= $msg['fecha_hora'] ?>
                                        <?php if ($msg['id_remitente'] == $_SESSION['usuario_id']): ?>
                                            <?php if ($msg['leido']): ?>
                                                <span title="Leído" class="ml-1">✔️✔️</span>
                                            <?php else: ?>
                                                <span title="Entregado" class="ml-1">✓</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?= BASE_URL ?>mensajes/enviar" method="POST" class="flex gap-2">
                <input type="hidden" name="destinatario" value="<?= $datos['contacto_id'] ?>">
                <input type="text" name="mensaje" required 
                       class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Escribe tu mensaje...">
                <button type="submit" class="bg-blue-600 text-white px-6 rounded-r-lg hover:bg-blue-700 transition">
                    Enviar
                </button>
            </form>
        </div>
    </main>

</body>
</html>