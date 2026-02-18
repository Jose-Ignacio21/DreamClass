<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Mi Historial de Feedback</h1>

            <?php if ($datos['error']): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <?= htmlspecialchars($datos['error']) ?>
                </div>
            <?php endif; ?>
            <?php if ($datos['success']): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    <?= htmlspecialchars($datos['success']) ?>
                </div>
            <?php endif; ?>

            <?php if (empty($datos['feedbacks'])): ?>
                <p class="text-gray-600">Aún no has dejado feedback. ¡Recuerda hacerlo después de cada clase!</p>
            <?php else: ?>
                <ul class="space-y-4">
                <?php foreach ($datos['feedbacks'] as $f): ?>
                    <li class="border-b pb-4">
                        <strong><?= htmlspecialchars($datos['rol'] === 'docente' ? $f['alumno_nombre'] : $f['docente_nombre']) ?></strong> - Fecha clase: <?= $f['fecha'] ?><br>
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

            <?php if ($datos['rol'] === 'alumno' && !empty($datos['clases_sin_feedback'])): ?>
                <h2 class="text-xl font-semibold mt-6 mb-3">Clases listas para feedback</h2>
                <ul class="space-y-2">
                <?php foreach ($datos['clases_sin_feedback'] as $c): ?>
                    <li>
                        Con <strong><?= htmlspecialchars($c['docente_nombre']) ?></strong> - <?= $c['fecha'] ?>
                        <a href="<?= BASE_URL ?>feedback/crear?clase=<?= $c['id_clase'] ?>" class="text-blue-600 hover:underline ml-2">Dejar feedback</a>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php elseif ($datos['rol'] === 'alumno'): ?>
                <p class="mt-4">No hay clases pendientes de feedback.</p>
            <?php endif; ?>

            <p class="mt-6">
                <a href="<?= BASE_URL . $datos['rol'] ?>" class="text-blue-600 hover:underline">Volver al panel</a>
            </p>
        </div>
    </main>

</body>
</html>