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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <?= $datos['rol'] === 'docente' ? 'Tareas Asignadas' : 'Mis Tareas' ?>
            </h1>

            <form method="GET" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar:</label>
                <select name="estado" onchange="this.form.submit()" class="border rounded p-2">
                    <option value="todas" <?= $datos['estado'] === 'todas' ? 'selected' : '' ?>>Todas</option>
                    <option value="pendientes" <?= $datos['estado'] === 'pendientes' ? 'selected' : '' ?>>Pendientes</option>
                    <option value="completadas" <?= $datos['estado'] === 'completadas' ? 'selected' : '' ?>>Completadas</option>
                </select>
            </form>

            <?php if ($datos['rol'] === 'docente'): ?>
                <p class="mb-4">
                    <a href="<?= BASE_URL ?>tareas/crear" class="text-blue-600 hover:underline">Asignar nueva tarea</a>
                </p>
            <?php endif; ?>

            <?php if (empty($datos['tareas'])): ?>
                <p class="text-gray-600">No hay tareas <?= $datos['estado'] === 'todas' ? '' : ' ' . $datos['estado'] ?>.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($datos['tareas'] as $t): ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-bold text-lg"><?= htmlspecialchars($t['titulo']) ?></h3>
                            <p class="text-gray-700 mt-1"><?= nl2br(htmlspecialchars($t['descripcion'])) ?></p>
                            
                            <div class="mt-2 text-sm text-gray-500">
                                <?php if ($datos['rol'] === 'docente'): ?>
                                    Para: <em><?= htmlspecialchars($t['alumno_nombre']) ?></em>
                                <?php else: ?>
                                    De: <em><?= htmlspecialchars($t['docente_nombre']) ?></em>
                                <?php endif; ?>
                                <br>
                                Asignada: <?= $t['fecha_asignacion'] ?>
                            </div>

                            <div class="mt-2">
                                Estado: 
                                <span class="<?= $t['completada'] ? 'text-green-600' : 'text-orange-500' ?>">
                                    <?= $t['completada'] ? 'Completada' : 'Pendiente' ?>
                                </span>
                            </div>

                            <?php if ($datos['rol'] === 'alumno' && !$t['completada']): ?>
                                <form action="<?= BASE_URL ?>tareas/procesar" method="POST" class="inline-block mt-2">
                                    <input type="hidden" name="accion" value="completar">
                                    <input type="hidden" name="id_tarea" value="<?= $t['id_tarea'] ?>">
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                        Marcar como completada
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if (!empty($t['ruta_archivo'])): ?>
                                <div class="mt-2">
                                    <a href="<?= BASE_URL . htmlspecialchars($t['ruta_archivo']) ?>" 
                                       target="_blank" 
                                       class="text-blue-600 hover:underline inline-flex items-center">
                                       📎 Ver archivo adjunto
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <p class="mt-6">
                <a href="<?= BASE_URL . $datos['rol'] ?>" class="text-blue-600 hover:underline">Volver al panel</a>
            </p>
        </div>
    </main>

</body>
</html>