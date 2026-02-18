<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Clases - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_alumno.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Explorar Academias</h1>
                <p class="text-gray-500">Encuentra el nivel que necesitas y apúntate para el próximo mes de clases.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-sm max-w-4xl mx-auto">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm max-w-4xl mx-auto text-center font-bold">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>

            <?php 
            $meses_espanol = [
                '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
                '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
                '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
            ];
            ?>

            <?php if (empty($grupos)): ?>
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 text-center max-w-2xl mx-auto mt-10">
                    <h3 class="text-xl font-bold text-gray-800">No hay grupos disponibles</h3>
                    <p class="text-gray-500">Actualmente los profesores no han abierto plazas para el próximo mes.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($grupos as $grupo): ?>
                        <?php 
                            $num_mes = date('m', strtotime($grupo['mes_anio']));
                            $anio = date('Y', strtotime($grupo['mes_anio']));
                            $mes_traducido = $meses_espanol[$num_mes] . ' ' . $anio;
                        ?>
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative">
                            
                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-blue-800 text-[10px] font-bold px-2 py-1 rounded-lg shadow-sm z-10 uppercase tracking-wider">
                                <?= $mes_traducido ?>
                            </div>

                            <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 text-white text-center pt-8">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-blue-600 text-2xl font-bold mx-auto mb-3 shadow-inner relative z-0">
                                    <?= strtoupper(substr($grupo['nombre_profe'], 0, 1)) ?>
                                </div>
                                <h3 class="font-bold text-lg leading-tight">Prof. <?= htmlspecialchars($grupo['nombre_profe'] . ' ' . $grupo['apellidos_profe']) ?></h3>
                                <p class="text-blue-200 text-xs mt-1 uppercase tracking-wide">Suscripción Mensual</p>
                            </div>

                            <div class="p-6 text-center">
                                <h4 class="text-xl font-extrabold text-gray-800 mb-2"><?= htmlspecialchars($grupo['nivel']) ?></h4>
                                
                                <div class="my-6">
                                    <span class="text-4xl font-extrabold text-green-500"><?= htmlspecialchars($grupo['precio']) ?>€</span>
                                    <span class="text-gray-400 font-medium text-sm">/mes</span>
                                </div>
                                
                                <form action="<?= BASE_URL ?>clases/reservar" method="POST">
                                    <input type="hidden" name="id_grupo" value="<?= $grupo['id_grupo'] ?>">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md shadow-blue-200">
                                        ¡Inscribirme Ahora!
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>