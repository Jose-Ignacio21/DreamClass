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
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">📚 Mis Clases</h2>
                
                <?php if ($datos['rol'] === 'alumno'): ?>
                    <a href="<?= BASE_URL ?>clases/crear" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                        ➕ Reservar clase
                    </a>
                <?php endif; ?>
            </div>

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

            <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-2 bg-white">
                            <option value="todos" <?= $datos['estado_filtro'] === 'todos' ? 'selected' : '' ?>>Todos</option>
                            <option value="pendiente" <?= $datos['estado_filtro'] === 'pendiente' ? 'selected' : '' ?>>Pendientes</option>
                            <option value="realizada" <?= $datos['estado_filtro'] === 'realizada' ? 'selected' : '' ?>>Realizadas</option>
                            <option value="cancelada" <?= $datos['estado_filtro'] === 'cancelada' ? 'selected' : '' ?>>Canceladas</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition">Filtrar</button>
                </form>
            </div>

            <?php if (empty($datos['clases'])): ?>
                <div class="text-center py-10 text-gray-500 bg-gray-50 rounded border border-dashed border-gray-300">
                    <p>No tienes clases registradas con este filtro.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($datos['clases'] as $clase): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        <?= htmlspecialchars($datos['rol'] === 'docente' ? $clase['alumno_nombre'] : $clase['docente_nombre']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?= $clase['fecha'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?= substr($clase['hora_inicio'],0,5) ?> - <?= substr($clase['hora_fin'],0,5) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $clase['estado'] === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($clase['estado'] === 'realizada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') ?>">
                                            <?= ucfirst($clase['estado']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php if ($datos['rol'] === 'docente' && $clase['estado'] === 'pendiente'): ?>
                                            <a href="<?= BASE_URL ?>clases/procesar?accion=realizar&id=<?= $clase['id_clase'] ?>" 
                                               class="text-green-600 hover:text-green-900 mr-3" title="Marcar Realizada">Realizada</a>
                                            <a href="<?= BASE_URL ?>clases/procesar?accion=cancelar&id=<?= $clase['id_clase'] ?>" 
                                               class="text-red-600 hover:text-red-900" 
                                               onclick="return confirm('¿Cancelar clase?')" title="Cancelar">Cancelar</a>
                                        <?php elseif ($datos['rol'] === 'alumno' && $clase['estado'] === 'pendiente'): ?>
                                            <a href="<?= BASE_URL ?>clases/procesar?accion=cancelar&id=<?= $clase['id_clase'] ?>" 
                                               class="text-red-600 hover:text-red-900 font-bold"
                                               onclick="return confirm('¿Cancelar clase?')">Cancelar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($datos['total_paginas'] > 1): ?>
                    <div class="mt-6 flex justify-center">
                        <nav class="inline-flex rounded-md shadow">
                            <?php if ($datos['pagina'] > 1): ?>
                                <a href="?pagina=<?= $datos['pagina'] - 1 ?>&estado=<?= urlencode($datos['estado_filtro']) ?>" 
                                   class="px-3 py-1 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Anterior
                                </a>
                            <?php endif; ?>
                            <span class="px-4 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-700">
                                Página <?= $datos['pagina'] ?> de <?= $datos['total_paginas'] ?>
                            </span>
                            <?php if ($datos['pagina'] < $datos['total_paginas']): ?>
                                <a href="?pagina=<?= $datos['pagina'] + 1 ?>&estado=<?= urlencode($datos['estado_filtro']) ?>" 
                                   class="px-3 py-1 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Siguiente
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>