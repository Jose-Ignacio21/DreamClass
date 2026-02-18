<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación Docente - DreamClass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

    <?php include __DIR__ . '/../layout/sidebar_docente.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <div class="px-8 pt-6">
            <?php include __DIR__ . '/../layout/topbar.php'; ?>
        </div>

        <main class="flex-1 px-8 pb-12 max-w-4xl mx-auto w-full">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Validación de Título</h1>
                <p class="text-gray-500 mt-2">Para garantizar la calidad de DreamClass, necesitamos verificar tu titulación académica.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Error</p>
                    <p><?= htmlspecialchars($_GET['error']) ?></p>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-700">Estado Actual:</h3>
                        <?php 
                            $estado = $docente['estado_validacion'] ?? 'pendiente';
                            $colores = [
                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                'validado' => 'bg-green-100 text-green-800',
                                'rechazado' => 'bg-red-100 text-red-800'
                            ];
                            $colorClass = $colores[$estado] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-3 py-1 rounded-full text-sm font-bold uppercase <?= $colorClass ?> mt-1 inline-block">
                            <?= $estado ?>
                        </span>
                    </div>
                    <?php if (!empty($docente['archivo_titulo'])): ?>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Archivo subido:</p>
                            <a href="<?= BASE_URL ?>public/uploads/titulos/<?= $docente['archivo_titulo'] ?>" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                Ver documento actual
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-8">
                    <form action="<?= BASE_URL ?>docente/procesar_validacion" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sube tu Título o Certificado</label>
                            
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition cursor-pointer relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Selecciona un archivo</span>
                                            <input id="file-upload" name="titulo" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required onchange="mostrarNombre(this)">
                                        </label>
                                        <p class="pl-1">o arrástralo aquí</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, PNG, JPG hasta 5MB</p>
                                    <p id="nombre-archivo" class="text-sm font-bold text-green-600 mt-2"></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center gap-2">
                                Enviar para Revisión
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg flex gap-4 items-start">
                    <span class="text-2xl">⏳</span>
                    <div>
                        <h4 class="font-bold text-blue-800">Tiempo de espera</h4>
                        <p class="text-sm text-blue-600">La revisión suele tardar entre 24 y 48 horas laborables.</p>
                    </div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg flex gap-4 items-start">
                    <span class="text-2xl">🔒</span>
                    <div>
                        <h4 class="font-bold text-blue-800">Privacidad</h4>
                        <p class="text-sm text-blue-600">Tu documento es confidencial y solo será visto por administradores.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        function mostrarNombre(input) {
            const nombre = input.files[0].name;
            document.getElementById('nombre-archivo').innerText = 'Archivo seleccionado: ' + nombre;
        }
    </script>
</body>
</html>