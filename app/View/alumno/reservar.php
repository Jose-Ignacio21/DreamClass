<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($datos['titulo']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">

    <?php include __DIR__ . '/../layout/sidebar_alumno.php'; ?>

    <main class="flex-1 p-6 max-w-6xl w-full">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Nueva Reserva de Clase</h2>

            <?php if (!empty($datos['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <?= htmlspecialchars($datos['error']) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>alumno/reservar" method="POST" class="space-y-6">
                
                <input type="hidden" name="accion" value="crear">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Docente</label>
                    <select name="id_docente" required class="w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">-- Selecciona un docente --</option>
                        <?php if (!empty($datos['docentes'])): ?>
                            <?php foreach ($datos['docentes'] as $doc): ?>
                                <option value="<?= $doc['id_usuario'] ?>"><?= htmlspecialchars($doc['nombre']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" name="fecha" min="<?= date('Y-m-d') ?>" required 
                           class="w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio</label>
                        <input type="time" name="hora_inicio" required 
                               class="w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora de fin</label>
                        <input type="time" name="hora_fin" required 
                               class="w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition shadow">
                        Reservar Clase
                    </button>
                    <a href="<?= BASE_URL ?>alumno" class="px-6 py-2 bg-gray-200 text-gray-800 font-medium rounded hover:bg-gray-300 transition">
                        Volver
                    </a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>