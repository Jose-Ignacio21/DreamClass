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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Asignar Nueva Tarea</h1>

            <?php if ($datos['error']): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <?= htmlspecialchars($datos['error']) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>tareas/procesar" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="accion" value="crear">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alumno</label>
                    <select name="id_alumno" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">-- Selecciona un alumno --</option>
                        <?php foreach ($datos['alumnos'] as $alum): ?>
                            <option value="<?= $alum['id_usuario'] ?>"><?= htmlspecialchars($alum['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="titulo" maxlength="150" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="4" placeholder="Ej: Repasar ecuaciones de segundo grado..." 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Archivo (opcional)</label>
                    <input type="file" name="archivo" accept=".pdf,.doc,.docx,.jpg,.png" 
                           class="w-full text-gray-700">
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Asignar Tarea</button>
                    <a href="<?= BASE_URL ?>tareas" class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">← Ver tareas asignadas</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>