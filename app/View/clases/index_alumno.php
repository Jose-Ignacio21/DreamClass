<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Clases - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_alumno.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12">
            
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Mis Suscripciones</h1>
                    <p class="text-gray-500">Aquí tienes los grupos en los que estás matriculado.</p>
                </div>
                <a href="<?= BASE_URL ?>clases/explorar" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 transition shadow-md">
                    Buscar más clases
                </a>
            </div>

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
                    <h3 class="text-xl font-bold text-gray-800">Aún no tienes clases</h3>
                    <p class="text-gray-500 mb-6">Explora nuestra academia y apúntate a tu primer grupo.</p>
                    <a href="<?= BASE_URL ?>clases/explorar" class="text-blue-600 font-bold hover:underline">Ir a explorar clases</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($grupos as $grupo): ?>
                        <?php 
                            $num_mes = date('m', strtotime($grupo['mes_anio']));
                            $anio = date('Y', strtotime($grupo['mes_anio']));
                            $mes_traducido = $meses_espanol[$num_mes] . ' ' . $anio;
                        ?>
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                            
                            <div class="absolute top-4 right-4 bg-green-100 text-green-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                Inscrito
                            </div>

                            <div class="p-6 border-b border-gray-100">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl font-bold mb-4">
                                    <?= strtoupper(substr($grupo['nombre_profe'], 0, 1)) ?>
                                </div>
                                <h3 class="font-bold text-lg text-gray-800 mb-1"><?= htmlspecialchars($grupo['nivel']) ?></h3>
                                <p class="text-gray-500 text-sm">Prof. <?= htmlspecialchars($grupo['nombre_profe'] . ' ' . $grupo['apellidos_profe']) ?></p>
                            </div>

                            <div class="bg-gray-50 p-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-500 text-sm">Mes:</span>
                                    <span class="font-bold text-gray-800 capitalize"><?= $mes_traducido ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-sm">Fecha de alta:</span>
                                    <span class="text-gray-600 text-sm"><?= date('d/m/Y', strtotime($grupo['fecha_inscripcion'])) ?></span>
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