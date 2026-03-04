<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($datos['titulo']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <?php include __DIR__ . '/../layout/sidebar_admin.php'; ?>

    <div class="flex-1 flex flex-col min-w-0">
        
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>
        
        <main class="flex-1 p-8 w-full max-w-7xl mx-auto">
            
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Bienvenido Admin</h1>
                <p class="text-gray-600 mt-2">Dashboard general de la plataforma</p>
            </header>

            <?php if ($datos['error']): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                    <?= htmlspecialchars($datos['error']) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($datos['success']): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <?= htmlspecialchars($datos['success']) ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Alumnos</h2>
                        <p class="text-3xl font-bold text-gray-800 mt-2"><?= $datos['total_alumnos'] ?></p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-green-500 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Docentes</h2>
                        <p class="text-3xl font-bold text-gray-800 mt-2"><?= $datos['total_docentes'] ?></p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Clases Creadas</h2>
                        <p class="text-3xl font-bold text-gray-800 mt-2"><?= $datos['total_clases'] ?></p>
                    </div>
                </div>
            </div>

        </main>
    </div> 
</body>
</html>