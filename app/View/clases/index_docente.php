<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Grupos - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Mis Grupos Mensuales</h1>
                <a href="<?= BASE_URL ?>clases/crear" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-blue-700 transition shadow-md flex items-center gap-2">
                    <span>+</span> Nuevo Grupo
                </a>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>

            <?php if (empty($grupos)): ?>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <h3 class="text-lg font-bold text-gray-800">Aún no tienes grupos</h3>
                    <p class="text-gray-500 mb-4">Anímate a publicar tu primer mes de clases.</p>
                    <a href="<?= BASE_URL ?>clases/crear" class="text-blue-600 font-bold hover:underline">Crear grupo ahora</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($grupos as $grupo): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                            
                            <div class="bg-blue-50 px-6 py-4 border-b border-blue-100 flex justify-between items-center">
                                <h4 class="font-bold text-blue-800 text-lg"><?= htmlspecialchars($grupo['nivel']) ?></h4>
                                <span class="bg-white text-blue-600 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                                    <?= date('m/Y', strtotime($grupo['mes_anio'])) ?>
                                </span>
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="text-gray-500 text-sm">Precio Mensual</div>
                                    <div class="font-bold text-gray-800 text-xl"><?= htmlspecialchars($grupo['precio']) ?> €</div>
                                </div>
                                <div class="flex justify-between items-center mb-6">
                                    <div class="text-gray-500 text-sm">Alumnos inscritos</div>
                                    <div class="font-bold <?= $grupo['total_alumnos'] > 0 ? 'text-green-600' : 'text-gray-400' ?> flex items-center gap-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <?= $grupo['total_alumnos'] ?>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-2 border-t border-gray-100 pt-4">
                                    
                                    <a href="<?= BASE_URL ?>clases/alumnos/<?= $grupo['id_grupo'] ?>" 
                                       class="w-full flex justify-center items-center py-2.5 px-4 border border-gray-200 text-gray-700 rounded-xl hover:border-blue-600 hover:bg-blue-600 hover:text-white font-bold text-sm transition duration-200">
                                        Ver Alumnos
                                    </a>
                                    
                                    <a href="<?= BASE_URL ?>historial/finalizar/<?= $grupo['id_grupo'] ?>" 
                                       onclick="return confirm('¿Estás seguro de finalizar este mes? La clase pasará a tu historial de ganancias y ya no estará activa.')" 
                                       class="w-full flex justify-center items-center gap-2 py-2.5 px-4 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 font-bold text-sm transition duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Finalizar Mes
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>