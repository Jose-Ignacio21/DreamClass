<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Grupo - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12 pt-4 max-w-3xl mx-auto w-full">
            
            <div class="mb-6">
                <a href="<?= BASE_URL ?>clases" class="text-gray-500 hover:text-blue-600 flex items-center gap-2 mb-2">
                    <span>←</span> Volver a mis grupos
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Publicar Mes de Clases</h1>
                <p class="text-gray-500">Abre plazas para tu mes de clases.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-sm">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>clases/procesar" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                
                <div class="mb-6">
                    <label for="nivel" class="block mb-2 text-sm font-bold text-gray-800">Nivel Educativo</label>
                    <select name="nivel" id="nivel" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition">
                        <option value="">Selecciona un nivel...</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                        <option value="Bachillerato">Bachillerato</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="mes_anio" class="block mb-2 text-sm font-bold text-gray-800">Mes y Año</label>
                    <input type="month" name="mes_anio" id="mes_anio" required min="<?= date('Y-m') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition">
                </div>

                <div class="mb-8">
                    <label for="precio" class="block mb-2 text-sm font-bold text-gray-800">Precio Mensual (€)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500 font-bold">€</span>
                        </div>
                        <input type="number" name="precio" id="precio" step="0.01" min="1" required placeholder="50.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-3 transition">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 px-5 rounded-xl hover:bg-blue-700 transition shadow-md">
                        Publicar Grupo
                    </button>
                    <a href="<?= BASE_URL ?>clases" class="bg-white text-gray-700 border border-gray-300 font-bold py-3 px-5 rounded-xl hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>