<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($datos['titulo']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <main class="flex-1 p-6 max-w-6xl w-full">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Feedbacks de mis Alumnos</h1>

            <?php if (empty($datos['feedbacks'])): ?>
                <p class="text-gray-600">Aún no has recibido feedback. ¡Sigue impartiendo clases!</p>
            <?php else: ?>
                <ul class="space-y-4">
                <?php foreach ($datos['feedbacks'] as $f): ?>
                    <li class="border-b pb-4">
                        <strong><?= htmlspecialchars($f['alumno_nombre']) ?></strong> - Fecha clase: <?= $f['fecha'] ?><br>
                        Calificación: 
                        <span class="text-yellow-500">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= $f['calificacion'] ? '★' : '☆' ?>
                            <?php endfor; ?>
                        </span><br>
                        <?php if (!empty($f['comentario'])): ?>
                            Comentario: "<?= htmlspecialchars($f['comentario']) ?>"
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <p class="mt-6">
                <a href="<?= BASE_URL ?>docente" class="text-blue-600 hover:underline">← Volver al panel</a>
            </p>
        </div>
    </main>

</body>
</html>