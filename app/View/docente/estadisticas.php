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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Mis Estadísticas</h1>

            <p><strong>Total de clases:</strong> <?= $datos['total'] ?></p>
            <p class="text-orange-600"><strong>Pendientes:</strong> <?= $datos['pendientes'] ?></p>
            <p class="text-green-600"><strong>Realizadas:</strong> <?= $datos['realizadas'] ?></p>
            <p class="text-red-600"><strong>Canceladas:</strong> <?= $datos['canceladas'] ?></p>

            <h2 class="text-xl font-semibold mt-6 mb-4">Clases recientes</h2>
            <?php if (empty($datos['clases'])): ?>
                <p class="text-gray-600">No hay clases recientes.</p>
            <?php else: ?>
                <ul class="space-y-2">
                <?php foreach ($datos['clases'] as $c): ?>
                    <li>
                        Con <strong><?= htmlspecialchars($c['alumno_nombre']) ?></strong> - 
                        <?= $c['fecha'] ?> a las <?= $c['hora_inicio'] ?> - 
                        <span class="<?= $c['estado'] === 'pendiente' ? 'text-orange-600' : ($c['estado'] === 'realizada' ? 'text-green-600' : 'text-red-600') ?>">
                            <?= ucfirst($c['estado']) ?>
                        </span>
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