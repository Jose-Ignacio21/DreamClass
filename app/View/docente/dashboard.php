<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($datos['titulo']) ?> - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <?php if ($datos['estado_validacion'] === 'pendiente' || $datos['estado_validacion'] === 'rechazado'): ?>
                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-8 rounded-r-lg shadow-sm flex justify-between items-center animate-pulse">
                    <div class="flex items-center gap-3">
                        <div>
                            <h3 class="text-orange-800 font-bold">Validación: <?= ucfirst($datos['estado_validacion']) ?></h3>
                            <p class="text-orange-700 text-sm">Sube tu titulación para ser un maestro validado.</p>
                        </div>
                    </div>
                    <a href="<?= BASE_URL ?>docente/validacion" class="bg-orange-500 text-white px-5 py-2 rounded-full font-bold hover:bg-orange-600 transition shadow-md whitespace-nowrap">
                        <?= ($datos['estado_validacion'] === 'rechazado') ? 'Reintentar' : 'Validar Ahora' ?>
                    </a>
                </div>
            <?php endif; ?>

            <h1 class="text-2xl font-bold text-gray-800 mb-6">Visión General</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Grupos Activos</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                                <?= $datos['stats']['total_grupos'] ?? 0 ?>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Alumnos</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                                <?= $datos['stats']['total_alumnos'] ?? 0 ?>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Ingresos</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                                <?= number_format($datos['stats']['ingresos_totales'] ?? 0, 2) ?>€
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Calidad Media</p>
                            <div class="flex items-center gap-2 mt-2">
                                <h3 class="text-3xl font-bold text-gray-800">
                                    <?= round($datos['feedback']['nota_media'] ?? 0, 1) ?>
                                </h3>
                                <span class="text-yellow-400 text-xl">★</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start"> 
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 min-h-[300px] flex flex-col">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Análisis de Feedback</h3>
                    
                    <?php if (($datos['feedback']['total_valoraciones'] ?? 0) > 0): ?>
                        <div class="relative flex-1 w-full flex justify-center items-center">
                            <canvas id="feedbackChart"></canvas>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-500">Basado en <?= $datos['feedback']['total_valoraciones'] ?> valoraciones.</p>
                        </div>
                    <?php else: ?>
                        <div class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed p-8">
                            <p class="text-center">Aún no has recibido valoraciones.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="lg:col-span-2">
                    <h3 class="font-bold text-gray-800 mb-4">Acciones Rápidas</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <a href="<?= BASE_URL ?>clases/crear" class="group bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-2xl shadow-lg shadow-blue-200 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between overflow-hidden relative h-[120px]">
                            <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                            </div>
                            
                            <div class="relative z-10 flex items-center gap-4">
                                <div class="bg-white/20 p-3 rounded-xl">
                                </div>
                                <div>
                                    <span class="block font-bold text-xl">Nuevo Grupo</span>
                                    <p class="text-blue-100 text-sm">Publica un mes de clases</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?= BASE_URL ?>clases" class="group bg-white hover:bg-gray-50 border border-gray-200 p-6 rounded-2xl shadow-sm transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-between h-[120px]">
                            <div class="flex items-center gap-4">
                                <div class="bg-blue-50 text-blue-600 p-3 rounded-xl group-hover:bg-blue-100 transition"></div>
                                <div>
                                    <span class="block font-bold text-gray-800 text-xl">Mis Grupos</span>
                                    <p class="text-gray-500 text-sm">Gestiona tus alumnos</p>
                                </div>
                            </div>
                            <div class="text-gray-300 group-hover:text-blue-600 transition">
                            </div>
                        </a>

                    </div>
                </div>
            </div>

        </main>
    </div>

    <?php if (($datos['feedback']['total_valoraciones'] ?? 0) > 0): ?>
    <script>
        const ctx = document.getElementById('feedbackChart').getContext('2d');
        // Tenemos valores de ejemplos para que no explote
        const positivos = 8; 
        const negativos = 2;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Positivo (4-5★)', 'Mejorable (1-3★)'],
                datasets: [{
                    data: [positivos, negativos], 
                    backgroundColor: ['#10B981', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%',
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>