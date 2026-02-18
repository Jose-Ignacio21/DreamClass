<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Historial y Ganancias - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Historial de mis Clases</h1>
                <p class="text-gray-500">Resumen economico y registro de todos tus grupos finalizados.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Grupos Finalizados</h3>
                </div>
                
                <?php if (empty($historial)): ?>
                    <div class="p-10 text-center">
                        <p class="text-gray-500 text-lg">Aún no has finalizado ningún grupo.<br>Cuando termines un mes, aparecerá aquí.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-gray-100 text-xs uppercase tracking-wider text-gray-400">
                                    <th class="p-4 font-bold">Mes / Nivel</th>
                                    <th class="p-4 font-bold text-center">Precio/Alumno</th>
                                    <th class="p-4 font-bold text-center">Alumnos Inscritos</th>
                                    <th class="p-4 font-bold text-right">Ganancia Final</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php foreach ($historial as $clase): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4">
                                            <p class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($clase['nivel']) ?></p>
                                            <p class="text-sm text-gray-500 uppercase tracking-wide"><?= date('M Y', strtotime($clase['mes_anio'])) ?></p>
                                        </td>
                                        <td class="p-4 text-center text-gray-600 font-medium">
                                            <?= number_format($clase['precio'], 2, ',', '.') ?> €
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full font-bold text-sm">
                                                <?= $clase['total_alumnos'] ?> alumnos
                                            </span>
                                        </td>
                                        <td class="p-4 text-right">
                                            <span class="text-xl font-extrabold text-green-600">
                                                +<?= number_format($clase['ganancias'], 2, ',', '.') ?> €
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>