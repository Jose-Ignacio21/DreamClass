<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Alumno - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_alumno.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-10 text-white shadow-xl mb-10 relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-4xl font-bold mb-4">¡Hola, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>!</h1>
                    <?php 
                        $tareasTotales = $datos['progreso']['total'];
                        $tareasHechas = $datos['progreso']['completadas'];
                        $pendientes = $tareasTotales - $tareasHechas;
                    ?>

                    <p class="text-blue-100 text-lg mb-8">
                        <?php if ($pendientes > 0): ?>
                            Continúa tu aprendizaje. Tienes <strong><?= $pendientes ?></strong> tarea<?= $pendientes > 1 ? 's' : '' ?> pendiente<?= $pendientes > 1 ? 's' : '' ?> para hoy.
                        <?php else: ?>
                            ¡Buen trabajo! No tienes tareas pendientes para hoy.
                        <?php endif; ?>
                    </p>
                    
                    <div class="flex gap-4">
                        <a href="<?= BASE_URL ?>tareas" class="bg-blue-800/50 backdrop-blur-sm border border-blue-400/30 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-800 transition inline-flex items-center gap-2">
                            Ver Tareas
                        </a>
                    </div>
                </div>
                <div class="absolute right-0 bottom-0 h-64 w-64 bg-white opacity-10 rounded-full blur-3xl transform translate-y-10 translate-x-10"></div>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-6">Tu Espacio de Aprendizaje</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="<?= BASE_URL ?>clases" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition relative overflow-hidden flex flex-col justify-center min-h-[140px]">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">Mis Clases</h3>
                        <p class="text-sm text-gray-500">Accede a tus cursos y materiales.</p>
                    </div>
                </a>

                <a href="<?= BASE_URL ?>mensajes" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition relative overflow-hidden flex flex-col justify-center min-h-[140px]">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">Mensajes</h3>
                        <p class="text-sm text-gray-500">Habla con tus profesores.</p>
                    </div>
                </a>

                <a href="<?= BASE_URL ?>feedback" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition relative overflow-hidden flex flex-col justify-center min-h-[140px]">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">Valoraciones</h3>
                        <p class="text-sm text-gray-500">Valora tus clases completadas.</p>
                    </div>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Próxima Clase</h3>
                    
                    <?php if ($datos['proxima_clase']): ?>
                        <div class="flex items-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="bg-white p-3 rounded-lg shadow-sm mr-4 text-center min-w-[70px]">
                                <span class="block text-xl font-bold text-blue-600">
                                    <?= date('H:i', strtotime($datos['proxima_clase']['hora_inicio'])) ?>
                                </span>
                                <span class="text-xs text-gray-500">
                                    <?= date('d M', strtotime($datos['proxima_clase']['fecha'])) ?>
                                </span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($datos['proxima_clase']['materia']) ?></h4>
                                <p class="text-sm text-gray-600">Prof. <?= htmlspecialchars($datos['proxima_clase']['nombre_profe'] . ' ' . $datos['proxima_clase']['apellido_profe']) ?></p>
                            </div>
                            <div class="ml-auto">
                                <a href="<?= BASE_URL ?>clase/unirse" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-bold transition shadow">
                                    Entrar
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl p-8 text-center border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 mb-2">No tienes clases programadas próximamente.</p>
                            <a href="<?= BASE_URL ?>clases" class="text-blue-600 font-bold hover:underline">Ver calendario completo</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="bg-blue-900 rounded-2xl p-6 shadow-sm text-white flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                    
                    <div>
                        <h3 class="font-bold text-lg mb-1 flex items-center gap-2">
                            🚀 Tu Progreso Diario
                        </h3>
                        <?php if ($datos['progreso']['total'] > 0): ?>
                            <p class="text-blue-200 text-sm">
                                Has completado <b><?= $datos['progreso']['completadas'] ?></b> de <b><?= $datos['progreso']['total'] ?></b> tareas para hoy.
                            </p>
                        <?php else: ?>
                            <p class="text-blue-200 text-sm">¡Sin tareas pendientes para hoy!</p>
                        <?php endif; ?>
                    </div>

                    <div class="w-full bg-blue-800 rounded-full h-3 mt-6">
                        <div class="bg-gradient-to-r from-green-400 to-blue-400 h-3 rounded-full transition-all duration-1000 ease-out" 
                             style="width: <?= $datos['progreso']['porcentaje'] ?>%"></div>
                    </div>
                    
                    <div class="text-right mt-1">
                        <span class="text-xs font-bold text-blue-200"><?= $datos['progreso']['porcentaje'] ?>% Completado</span>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>